<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

$user_id = $_SESSION['user_id'];


$sql = "SELECT cm.chat_message_id,
cm.chat_code,
 cm.chat_message, cm.sender_id, cm.chat_sent_at,
       u.user_name
FROM chat_messages cm
JOIN users u ON cm.sender_id = u.user_id
WHERE cm.sender_id = ? OR cm.receiver_id = ?
ORDER BY cm.chat_sent_at ASC
";



$stmt = $mysqli->prepare($sql);
$stmt->bind_param('ss', $user_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {

    $isMe = $row['sender_id'] == $user_id;
    $chatClass = $isMe ? 'chat-message me' : 'chat-message other';
    $senderName = $isMe ? 'Me' : htmlspecialchars($row['user_name']);
    $chatMessage = htmlspecialchars($row['chat_message']);
    $chatId = htmlspecialchars($row['chat_message_id']);
    $chatCode = htmlspecialchars($row['chat_code']);
    $chatTime = date('d M Y h:i A', strtotime($row['chat_sent_at']));
    echo "<div class=\"mail-list\" id=\"mailList\" data-sender-name=\"{$senderName}\" data-message=\"{$chatMessage}\" data-chat-id=\"{$chatId}\" data-chat-code=\"{$chatCode}\">
    <div class=\"col-10 container d-flex justify-content-between\" style=\"cursor: pointer;\">
        <p class=\"sender-name\" id=\"sender-name\">{$senderName}</p>
        <span class=\"message_text\" id=\"message-text\">{$chatMessage}</span>
    </div>
</div>";
 

}
