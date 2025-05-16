<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

$response = ['success' => false];

if(!isset($_SESSION['user_id'])){
    $response['error'] = 'Unauthorized access.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

header('Content-Type: application/json');

try{
    $property_id = trim($_POST['property_id'] ?? '');
    $stmt = $mysqli->prepare("DELETE FROM properties WHERE property_id = ?");
   $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $stmt->close();
    $response['success'] = true;
    $response['message'] = 'Property deleted successfully.';
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response['error'] = 'Error deleting property: ' . $e->getMessage();
    $response['message'] = 'Error deleting property.';
    echo json_encode($response);
    exit;
}

