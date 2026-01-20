<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

$user_id = $_SESSION['user_id'];
$chat_code = $_GET['chat_code'] ?? '';

if ($chat_code === '') {
    exit('Invalid chat');
}

$sql = "SELECT cm.chat_message, cm.sender_id, cm.chat_sent_at,
       u.user_name
FROM chat_messages cm
JOIN users u ON cm.sender_id = u.user_id
WHERE cm.chat_code = ?
ORDER BY cm.chat_sent_at ASC
";


$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $chat_code);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {

    $isMe = $row['sender_id'] == $user_id;

    echo '
    <div class="message ' . ($isMe ? 'text-end' : 'text-start') . '">
        <div class="badge bg-' . ($isMe ? 'primary' : 'secondary') . '">
            ' . htmlspecialchars($row['chat_message']) . '
        </div>
        <small class="d-block text-muted">
            ' . date('H:i', strtotime($row['chat_sent_at'])) . '
        </small>
    </div>';
}
