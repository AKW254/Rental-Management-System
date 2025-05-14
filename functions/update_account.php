<?php
session_start();
require_once('../config/config.php');

// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

// Sanitize input
$user_id = $_SESSION['user_id'];
$user_name = trim($_POST['user_name'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');
$user_phone = trim($_POST['user_phone'] ?? '');

// Basic validation
if (empty($user_name) || empty($user_email)) {
    $response['error'] = 'Name and Email are required.';
    echo json_encode($response);
    exit;
}

if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    $response['error'] = 'Invalid email format.';
    echo json_encode($response);
    exit;
}

// Sanitize phone number (optional)
if (!empty($user_phone)) {
    // Remove spaces, dashes, etc., for proper format
    $user_phone = preg_replace('/[^0-9+]/', '', $user_phone);
    if (!preg_match('/^\+?[0-9]{7,15}$/', $user_phone)) {
        $response['error'] = 'Invalid phone number format.';
        echo json_encode($response);
        exit;
    }
}

try {
    // Check for duplicate email
    $check = $mysqli->prepare("SELECT user_id FROM users WHERE user_email = ? AND user_id != ?");
    if (!$check) {
        throw new Exception('Database error: ' . $mysqli->error);
    }
    $check->bind_param('si', $user_email, $user_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        throw new Exception('Email is already taken.');
    }

    // Update user record
    $update = $mysqli->prepare("UPDATE users SET user_name = ?, user_email = ?, user_phone = ? WHERE user_id = ?");
    if (!$update) {
        throw new Exception('Database error: ' . $mysqli->error);
    }
    $update->bind_param('sssi', $user_name, $user_email, $user_phone, $user_id);

    if ($update->execute()) {
        // Update session data
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_phone'] = $user_phone;

        $response['success'] = true;
        $response['message'] = 'Account updated successfully.';
        $response['updated_data'] = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'user_phone' => $user_phone
        ];
    } else {
        throw new Exception('Failed to update account. Please try again.');
    }

    // Close statements
    $check->close();
    $update->close();
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
