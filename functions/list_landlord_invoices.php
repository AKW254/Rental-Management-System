<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if (!$_SESSION['user_id']) {

    exit;
}
$sql = "SELECT inv.invoice_id, rm.room_title, inv.invoice_date, inv.invoice_due_date, inv.invoice_amount, inv.invoice_status FROM invoices AS inv
        JOIN rental_agreements AS ra ON inv.agreement_id = ra.agreement_id
        JOIN rooms AS rm ON ra.room_id = rm.room_id
        join properties AS pm ON rm.property_id = pm.property_id
        WHERE pm.property_manager_id = " . $_SESSION['user_id'] . "
        ORDER BY inv.invoice_date DESC";
$result = $mysqli->query($sql);

$invoices = [];
while ($row = $result->fetch_assoc()) {
    $invoices[] = $row;
}

echo json_encode($invoices);