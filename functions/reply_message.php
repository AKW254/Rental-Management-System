<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
include('../functions/create_notification.php');

check_login();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to reply message', 1);
    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access'
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Read JSON input (VERY IMPORTANT)
$data = json_decode(file_get_contents("php://input"), true);

$chat_code = trim($data['chat_code'] ?? '');
$message   = trim($data['message'] ?? '');

// Validate input
if (empty($chat_code) || empty($message)) {
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to reply message - missing chat code or message', 1);
    echo json_encode([
        'success' => false,
        'message' => 'Missing chat code or message'
    ]);
    exit;
}

// OPTIONAL: get receiver_id from original chat
$sql = "SELECT 
            CASE 
                WHEN sender_id = ? THEN receiver_id
                ELSE sender_id
            END AS receiver_id
        FROM chat_messages
        WHERE chat_code = ?
        LIMIT 1";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('is', $user_id, $chat_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to reply message - invalid chat thread', 1);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid chat thread'
    ]);
    exit;
}

$row = $result->fetch_assoc();
$receiver_id = $row['receiver_id'];

// Insert reply
$insert = "INSERT INTO chat_messages 
           (chat_code, sender_id, receiver_id, chat_message, chat_sent_at)
           VALUES (?, ?, ?, ?, NOW())";

$stmt = $mysqli->prepare($insert);
$stmt->bind_param('siis', $chat_code, $user_id, $receiver_id, $message);

if ($stmt->execute()) {
    create_notification($mysqli, $_SESSION['user_id'], '1', 'Replied to message successfully', 1);
    echo json_encode([
        'success' => true,
        'message' => 'Reply sent successfully'
    ]);
} else {
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to reply message', 1);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send reply'
    ]);
}
