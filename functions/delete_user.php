<?php 
session_start();
include('../config/config.php');
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}
// Sanitize input
$user_id = trim($_POST['user_id'] ?? '');
// Basic validation
if (empty($user_id)) {
    $response['error'] = 'User ID is required.';
    echo json_encode($response);
    exit;
}

try {
    //IF user is currently logged in
    if ($_SESSION['user_id'] == $user_id) {
        // Delete the user and log them out
        $delete = $mysqli->prepare("DELETE FROM users WHERE user_id = ?");
        if (!$delete) {
            throw new Exception('Database error: ' . $mysqli->error);
        }
        $delete->bind_param('i', $user_id);
        if ($delete->execute()) {
            $response['success'] = true;
            $response['message'] = 'User deleted successfully. You have been logged out.';
            exit;
        } else {
            throw new Exception('Error deleting record: ' . $delete->error);
        }
    } else {
        // Delete the user
        $delete = $mysqli->prepare("DELETE FROM users WHERE user_id = ?");
        if (!$delete) {
            throw new Exception('Database error: ' . $mysqli->error);
        }
        $delete->bind_param('i', $user_id);
        if ($delete->execute()) {
            $response['success'] = true;
            $response['message'] = 'User deleted successfully.';
        } else {
            throw new Exception('Error deleting record: ' . $delete->error);
        }
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);
exit;