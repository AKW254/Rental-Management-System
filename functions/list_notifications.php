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
//2.Query Notification record
$sql= "SELECT nt.notification_id,us.user_name,
nt.notification_type,nt.notification_message,nt.sent_at,nt.notification_status FROM notifications AS nt INNER JOIN users AS us ON nt.user_id = us.user_id";
$result = $mysqli->query($sql);
$notifications = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $notifications[] = $row;
} 
echo json_encode($notifications);

