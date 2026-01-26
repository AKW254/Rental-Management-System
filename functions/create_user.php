<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
require_once('../functions/create_notification.php');
// Set response header
header('Content-Type: application/json');

$response = ['success' => false];



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
    if ($mail->send() && create_notification($mysqli, $_SESSION['user_id'], '1', 'User created successfully and mail sent', 1)) {
        $response['success'] = true;
        $response['message'] = 'User created successfully. Please check your email for the password.';
    } else {
        $response['error'] = 'User created, but email not sent: ' . $mail->ErrorInfo;
        create_notification($mysqli, $_SESSION['user_id'], '1', 'User created but failed to send mail', 1);
    }
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) { // Duplicate entry error code
        $response['error'] = 'Duplicate entry: A user with the same email or phone number already exists.';
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create user - duplicate entry', 1);
    } else {
        $response['error'] = 'Failed to create user: ' . $e->getMessage();
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create user', 1);
    }
}

echo json_encode($response);
exit;