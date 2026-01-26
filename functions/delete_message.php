<?php
include('../config/config.php');
session_start();
include('../config/checklogin.php');
check_login();
$user_id = $_SESSION['user_id'];

header('Content-Type: text/html; charset=utf-8');
/* Read JSON body not form data */
$data = json_decode(file_get_contents("php://input"), true);
$chat_message_id = $data['chat_id'] ?? '';

$stmt = $mysqli->prepare("DELETE FROM chat_messages WHERE chat_message_id = ? AND (sender_id = ? OR receiver_id = ?)");
$stmt->bind_param('sss', $chat_message_id, $user_id, $user_id);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    $response['success'] = true;
    $response['message'] = 'Message deleted successfully.';
    echo json_encode($response);
    exit;
} else {
    $response['success'] = false;
    $response['message'] = 'Failed to delete message or message not found.';
    echo json_encode($response);
    exit;
}