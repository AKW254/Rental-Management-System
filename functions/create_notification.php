<?php

function create_notification($mysqli, $recipient_id, $title, $message, $status)
{
    $stmt = $mysqli->prepare(
        "INSERT INTO notifications 
        (user_id, notification_type, notification_message, sent_at, notification_status) 
        VALUES (?, ?, ?, NOW(), ?)"
    );

    $stmt->bind_param('issi', $recipient_id, $title, $message, $status);

    return $stmt->execute();
}
