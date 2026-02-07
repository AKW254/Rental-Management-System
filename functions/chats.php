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
    $chatClass = $isMe ? 'is-me' : 'is-other';
    $senderName = $isMe ? 'Me' : htmlspecialchars($row['user_name'], ENT_QUOTES, 'UTF-8');
    $chatMessage = htmlspecialchars($row['chat_message'], ENT_QUOTES, 'UTF-8');
    $chatId = htmlspecialchars($row['chat_message_id'], ENT_QUOTES, 'UTF-8');
    $chatCode = htmlspecialchars($row['chat_code'], ENT_QUOTES, 'UTF-8');
    $chatTime = date('d M Y h:i A', strtotime($row['chat_sent_at']));
    $senderInitial = strtoupper(substr($senderName, 0, 1));
    if ($senderInitial === '') {
        $senderInitial = '?';
    }
    echo "<div class=\"mail-list chat-list-item {$chatClass}\" data-sender-name=\"{$senderName}\" data-message=\"{$chatMessage}\" data-chat-id=\"{$chatId}\" data-chat-code=\"{$chatCode}\" data-chat-time=\"{$chatTime}\">
    <div class=\"chat-list-avatar\" aria-hidden=\"true\">{$senderInitial}</div>
    <div class=\"chat-list-body\">
        <div class=\"chat-list-top\">
            <span class=\"sender-name\">{$senderName}</span>
            <span class=\"chat-time\">{$chatTime}</span>
        </div>
        <div class=\"message_text\">{$chatMessage}</div>
    </div>
</div>";
 

}
