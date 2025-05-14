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

// Declare variables
$user_id = trim($_POST['user_id'] ?? '');
$role_id = trim($_POST['role_id'] ?? '');

// Update User
$sql = "UPDATE users SET role_id = '$role_id' WHERE user_id = '$user_id'";
if ($mysqli->query($sql) === TRUE) {
    $response['success'] = true;
    $response['message'] = 'Role updated successfully';
    echo json_encode($response);
    exit;
} else {
    $response['error'] = 'Error updating record: ' . $mysqli->error;
    $response['message'] = 'Failed to update role';
    echo json_encode($response);
    exit;
}

