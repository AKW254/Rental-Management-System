<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
require_once('../functions/create_notification.php');
check_login();

// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {

    respondWithError('Unauthorized access.');
}

$user_id = $_SESSION['user_id'];
$user_password = trim($_POST['userPassword'] ?? '');
$user_confirm_password = trim($_POST['userConfirmPassword'] ?? '');

// Validate input
if (empty($user_password) || empty($user_confirm_password)) {
    respondWithError('Please fill in all fields.');
}

if ($user_password !== $user_confirm_password) {
    respondWithError('Passwords do not match.');
}

if (!isValidPassword($user_password)) {
    respondWithError('Password must be between 8 and 20 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
}

// Check if the new password is the same as the old password
$stored_hashed_password = getStoredPassword($mysqli, $user_id);
if (password_verify($user_password, $stored_hashed_password)) {
    respondWithError('New password cannot be the same as the old password.');
}

// Hash the new password and update it in the database
if (updatePassword($mysqli, $user_id, $user_password)) {
 create_notification($mysqli, $_SESSION['user_id'], '1', 'Password updated successfully', 1);
    $response['success'] = true;
    $response['message'] = 'Password updated successfully.';
} else {
    respondWithError('Failed to update password.');
}

$mysqli->close();
echo json_encode($response);

// Helper functions
function respondWithError($error) {
    global $response;
    $response['error'] = $error;
    echo json_encode($response);
    exit;
}

function isValidPassword($password) {
    return strlen($password) >= 8 && strlen($password) <= 20 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password) &&
           preg_match('/[\W_]/', $password);
}

function getStoredPassword($mysqli, $user_id) {
    $stmt = $mysqli->prepare("SELECT user_password FROM users WHERE user_id = ?");
    if (!$stmt) {
        respondWithError('Database error.');
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_hashed_password);
    $stmt->fetch();
    $stmt->close();
    return $stored_hashed_password;
}

function updatePassword($mysqli, $user_id, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE users SET user_password = ? WHERE user_id = ?");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('si', $hashed_password, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
