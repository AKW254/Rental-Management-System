<?php
session_start();
include('../config/config.php');
header('Content-Type: application/json');
include('../config/checklogin.php');
check_login();
$response = ['success' => false];
// Declare variables
$recipient_id = $_SESSION['user_id'];

function create_notification($mysqli, $recipient_id, $title, $message,$status)  {
    $stmt = $mysqli->prepare("INSERT INTO notifications (user_id,notification_type,notification_message,sent_at,notification_status) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param('issis', $recipient_id, $title, $message,$status);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}