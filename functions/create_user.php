<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

// Declare variables
$user_name = trim($_POST['user_name'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');
$user_phone = trim($_POST['user_phone'] ?? '');
$role_id = trim($_POST['role_id'] ?? '');
$role_type = trim($_POST['role_type'] ?? '');

// Generate default password which meets password requirements
$user_password = $user_gen_password;
// Hash the password
$user_hash_password = password_hash($user_password, PASSWORD_DEFAULT);

try {
    // Create User
    $sql = "INSERT INTO users (user_name, user_email, user_phone, user_password, role_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssssi', $user_name, $user_email, $user_phone, $user_hash_password, $role_id);
    $stmt->execute();

    include('../mailers/user_onboarding.php');
    if ($mail->send()) {
        $response['success'] = true;
        $response['message'] = 'User created successfully. Please check your email for the password.';
    } else {
        $response['error'] = 'User created, but email not sent: ' . $mail->ErrorInfo;
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) { // Duplicate entry error code
        $response['error'] = 'Duplicate entry: A user with the same email or phone number already exists.';
    } else {
        $response['error'] = 'Failed to create user: ' . $e->getMessage();
    }
}

echo json_encode($response);
exit;