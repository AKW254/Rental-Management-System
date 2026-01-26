<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();

// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to edit user', 1);
    echo json_encode($response);
    exit;
}

// Sanitize input
$user_id = trim($_POST['user_id'] ?? '');
$user_name = trim($_POST['user_name'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');
$user_phone = trim($_POST['user_phone'] ?? '');

// update sql
try{
    $sql = "UPDATE users SET user_name = ?, user_email = ?, user_phone = ? WHERE user_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit user', 1);
        throw new Exception('Prepare failed: ' . $mysqli->error);
    }
} catch (Exception $e) {
    $response['error'] = 'Database error: ' . $e->getMessage();
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit user', 1);
    echo json_encode($response);
    exit;
}
$sql="UPDATE users SET user_name = ?, user_email = ?, user_phone = ? WHERE user_id = ?";
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param('sssi', $user_name, $user_email, $user_phone, $user_id);
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'User updated successfully';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'User edited successfully', 1);
} else {
    $response['error'] = 'Error updating record: ' . $stmt->error;
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit user', 1);
}

echo json_encode($response);
exit;  
