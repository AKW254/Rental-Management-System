<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if(!$_SESSION['user_id']) {

exit;
}
//2.Query Payment record
$sql= "SELECT payment_id,py.invoice_id,payment_amount,payment_method,payment_transaction_id,payment_created_at FROM payments AS py
INNER JOIN invoices AS iv ON iv.invoice_id = py.invoice_id
INNER JOIN rental_agreements AS ra ON ra.agreement_id = iv.agreement_id
INNER JOIN rooms AS rm ON rm.room_id = ra.room_id
INNER JOIN properties AS pm ON pm.property_id = rm.property_id
WHERE pm.property_manager_id = " . $_SESSION['user_id'] . "
 ORDER BY payment_id DESC";
$result = $mysqli->query($sql);
$payments = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $payments[] = $row;
}
echo json_encode($payments);