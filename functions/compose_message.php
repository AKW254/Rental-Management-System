<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
require_once('../functions/create_notification.php');
check_login();
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if (empty($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to compose message', 1);
    echo json_encode($response);
    exit;
}
//Dclare varaibles
$to_username = trim($_POST['username'] ?? '');
$message = trim($_POST['message'] ?? '');
$from_user_id = $_SESSION['user_id'];
$chat_code = bin2hex(random_bytes(8));
//Fetch recipient user id
$stmt = $mysqli->prepare("SELECT user_id,user_name FROM users WHERE user_name = ?");
$stmt->bind_param("s", $to_username);
$stmt->execute();
$result = $stmt->get_result();
$to_user = $result->fetch_assoc();
$stmt->close();
if (!$to_user) {
    $response['error'] = 'Recipient user not found.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to compose message - recipient not found', 1);
    echo json_encode($response);
    exit;
}
$to_user_id = $to_user['user_id'];

try {
    $stmt = $mysqli->prepare("INSERT INTO chat_messages (sender_id, receiver_id, chat_message,chat_code) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $from_user_id, $to_user_id, $message, $chat_code);
    $stmt->execute();
    $stmt->close();

    //Send success response
    $response['success'] = true;
    $response['message'] = 'Message sent successfully.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Message composed successfully', 1);

    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = 'Failed to send message.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to compose message', 1);
    echo json_encode($response);
    exit;
}
