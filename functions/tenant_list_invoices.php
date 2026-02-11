<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

header('Content-Type: application/json');

if (!$_SESSION['user_id']) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT inv.invoice_id, rm.room_title, inv.invoice_date, inv.invoice_due_date, inv.invoice_amount, inv.invoice_status
        FROM invoices AS inv
        INNER JOIN rental_agreements AS ra ON inv.agreement_id = ra.agreement_id
        INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
        WHERE ra.tenant_id = ?
        ORDER BY inv.invoice_date DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$invoices = [];
while ($row = $result->fetch_assoc()) {
    $invoices[] = $row;
}

echo json_encode($invoices);
