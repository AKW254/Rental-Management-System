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

$sql = "SELECT py.payment_id, py.invoice_id, py.payment_amount, py.payment_method,
        py.payment_transaction_id, py.payment_created_at
        FROM payments AS py
        INNER JOIN invoices AS iv ON iv.invoice_id = py.invoice_id
        INNER JOIN rental_agreements AS ra ON ra.agreement_id = iv.agreement_id
        WHERE ra.tenant_id = ?
        ORDER BY py.payment_id DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$payments = [];
while ($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

echo json_encode($payments);
