<?php 
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
//Current User
$user_id = $_SESSION['user_id'];
// Fetch all chats
$sql = "SELECT DISTINCT chat_messages.chat_code, chat_messages.chat_message, chat_messages.sender_id, chat_messages.receiver_id, users.user_name AS sender_name, receivers.user_name AS receiver_name FROM chat_messages
INNER JOIN users ON chat_messages.sender_id = users.user_id
INNER JOIN users AS receivers ON chat_messages.receiver_id = receivers.user_id
 WHERE sender_id = ? OR receiver_id = ? ORDER BY chat_sent_at DESC";
$smt = $mysqli->prepare($sql);
$smt->bind_param('ii', $user_id, $user_id);
$smt->execute();
$res = $smt->get_result();

if ($res->num_rows === 0) {
    echo '<p class="text-center">No messages found.</p>';
    exit;
}else {
    while ($row = $res->fetch_assoc()) {

        // show sender name (or You)
        $senderName = ($row['sender_id'] === $user_id) ? 'You' : htmlspecialchars($row['sender_name']);

        echo '
<div class="mail-list"
     data-chat-code="' . htmlspecialchars($row['chat_code']) . '"
     data-sender="' . $senderName . '"
     data-message="' . htmlspecialchars($row['chat_message']) . '">

    <div class="col-10 container d-flex justify-content-between" style="cursor:pointer;">
        <p class="sender-name">' . $senderName . '</p>
        <span class="message_text text-truncate">
            ' . htmlspecialchars($row['chat_message']) . '
        </span>
    </div>
</div>';
    }
}