<?php
session_start();
header('Content-Type: application/json');

require_once '../config/config.php'; 

$response = ['success' => false, 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name  = trim($_POST['user_name'] ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $user_phone = trim($_POST['user_phone'] ?? '');
    $user_id    = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $response['message'] = 'Unauthorized access.';
        echo json_encode($response);
        exit;
    }

    // Optional: Validate input (e.g. filter_var for email)

    $stmt = $mysqli->prepare("UPDATE users SET user_name = ?, user_email = ?, user_phone = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $user_name, $user_email, $user_phone, $user_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Account updated successfully.';
    } else {
        $response['message'] = 'Failed to update account.';
    }

    $stmt->close();
}

echo json_encode($response);
