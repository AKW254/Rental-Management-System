<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Phpml\Clustering\KMeans;

$tenant_risk_sql = "
    SELECT
        u.user_id,
        u.user_name,
        u.user_email,
        u.user_phone,
        ra.agreement_id,
        ra.agreement_status,
        rm.room_title,
        COUNT(DISTINCT inv.invoice_id) AS total_invoices,
        COUNT(DISTINCT CASE WHEN inv.invoice_status = 'overdue' THEN inv.invoice_id END) AS overdue_invoices,
        COUNT(DISTINCT CASE WHEN inv.invoice_status = 'unpaid' THEN inv.invoice_id END) AS unpaid_invoices,
        COUNT(DISTINCT CASE WHEN pay.payment_status = 'failed' THEN pay.payment_id END) AS failed_payments,
        COUNT(DISTINCT CASE
            WHEN pay.payment_status = 'success' AND pay.payment_date > inv.invoice_due_date THEN pay.payment_id
        END) AS late_payments,
        MAX(CASE WHEN pay.payment_status = 'success' THEN pay.payment_date END) AS last_payment_date,
        COUNT(DISTINCT mr.maintenance_request_id) AS maintenance_requests,
        COUNT(DISTINCT CASE
            WHEN mr.maintenance_request_status IN ('submitted', 'In Progress', 'in progress', 'Submitted') THEN mr.maintenance_request_id
        END) AS open_maintenance
    FROM users u
    INNER JOIN rental_agreements ra ON ra.tenant_id = u.user_id
    INNER JOIN rooms rm ON ra.room_id = rm.room_id
    INNER JOIN properties ps ON rm.property_id = ps.property_id
    LEFT JOIN invoices inv ON inv.agreement_id = ra.agreement_id
    LEFT JOIN payments pay ON pay.invoice_id = inv.invoice_id
    LEFT JOIN maintenance_requests mr ON mr.agreement_id = ra.agreement_id
    WHERE ps.property_manager_id = ?
      AND u.role_id = 3
      AND ra.agreement_status = 'Active'
    GROUP BY
        u.user_id, u.user_name, u.user_email, u.user_phone,
        ra.agreement_id, ra.agreement_status, rm.room_title
";

$tenant_risk_stmt = $mysqli->prepare($tenant_risk_sql);
$tenant_risk_stmt->bind_param('i', $_SESSION['user_id']);
$tenant_risk_stmt->execute();
$tenant_risk_result = $tenant_risk_stmt->get_result();

$tenant_risk_rows = [];
$samples = [];
$raw_scores = [];
$today = new DateTime();

while ($row = $tenant_risk_result->fetch_assoc()) {
    $overdue = (int)$row['overdue_invoices'];
    $unpaid = (int)$row['unpaid_invoices'];
    $late = (int)$row['late_payments'];
    $failed = (int)$row['failed_payments'];
    $open_maintenance = (int)$row['open_maintenance'];

    $days_since_last_payment = 120;
    if (!empty($row['last_payment_date'])) {
        $last = new DateTime($row['last_payment_date']);
        $days_since_last_payment = $last->diff($today)->days;
    }

    $row['days_since_last_payment'] = $days_since_last_payment;

    // Heuristic base score (0-100), later paired with ML cluster for level.
    $score = ($overdue * 25) + ($unpaid * 15) + ($late * 10) + ($failed * 15) + ($open_maintenance * 5);
    if ($days_since_last_payment > 45) {
        $score += 10;
    }
    $score = min(100, $score);

    $raw_scores[] = $score;
    $samples[] = [
        $overdue,
        $unpaid,
        $late,
        $failed,
        $open_maintenance,
        $days_since_last_payment
    ];

    $row['risk_score'] = $score;
    $tenant_risk_rows[] = $row;
}

// Default labels in case ML cannot run reliably.
$labels = array_fill(0, count($tenant_risk_rows), 'Medium');

if (count($samples) >= 3) {
    // Min-max normalize features for KMeans.
    $mins = $samples[0];
    $maxs = $samples[0];
    foreach ($samples as $sample) {
        foreach ($sample as $idx => $value) {
            $mins[$idx] = min($mins[$idx], $value);
            $maxs[$idx] = max($maxs[$idx], $value);
        }
    }

    $normalized = [];
    foreach ($samples as $sample) {
        $row = [];
        foreach ($sample as $idx => $value) {
            $range = $maxs[$idx] - $mins[$idx];
            $row[] = $range > 0 ? ($value - $mins[$idx]) / $range : 0.0;
        }
        $normalized[] = $row;
    }

    $kmeans = new KMeans(3);
    $clusters = $kmeans->cluster($normalized);

    // Map each sample to cluster index.
    $cluster_map = [];
    foreach ($clusters as $cluster_idx => $cluster_samples) {
        foreach ($cluster_samples as $sample) {
            $cluster_map[json_encode($sample)] = $cluster_idx;
        }
    }

    // Compute average risk score per cluster to rank them.
    $cluster_scores = array_fill(0, 3, ['sum' => 0, 'count' => 0]);
    foreach ($normalized as $i => $sample) {
        $key = json_encode($sample);
        if (!isset($cluster_map[$key])) {
            continue;
        }
        $c = $cluster_map[$key];
        $cluster_scores[$c]['sum'] += $raw_scores[$i];
        $cluster_scores[$c]['count'] += 1;
    }

    $cluster_avgs = [];
    foreach ($cluster_scores as $idx => $score_data) {
        $avg = $score_data['count'] > 0 ? $score_data['sum'] / $score_data['count'] : 0;
        $cluster_avgs[$idx] = $avg;
    }

    // Sort clusters by avg score to assign Low/Medium/High.
    asort($cluster_avgs);
    $levels = ['Low', 'Medium', 'High'];
    $ranked = array_keys($cluster_avgs);
    $cluster_level = [];
    foreach ($ranked as $rank => $cluster_idx) {
        $cluster_level[$cluster_idx] = $levels[$rank] ?? 'Medium';
    }

    $labels = [];
    foreach ($normalized as $sample) {
        $key = json_encode($sample);
        $cluster_idx = $cluster_map[$key] ?? 1;
        $labels[] = $cluster_level[$cluster_idx] ?? 'Medium';
    }
}

foreach ($tenant_risk_rows as $i => $row) {
    $tenant_risk_rows[$i]['risk_level'] = $labels[$i] ?? 'Medium';
}
