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
$sql= "SELECT payment_id,payment_amount,payment_method,payment_transaction_id,payment_created_at FROM payments ORDER BY payment_id DESC";
$result = $mysqli->query($sql);
$payments = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $payments[] = $row;
}
echo json_encode($payments);