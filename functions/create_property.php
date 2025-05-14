<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

if(!$_SESSION['user_id']) {
    $response['error'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

//Declare variables
$property_manager_id = trim($_POST['property_manager_id'] ?? '');
$property_name = trim($_POST['property_name'] ?? '');
$property_location = trim($_POST['property_location'] ?? '');
$property_description = trim($_POST['property_description'] ?? '');

try{
    $stmt = $mysqli->prepare("INSERT INTO properties (property_manager_id, property_name, property_location, property_description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $property_manager_id, $property_name, $property_location, $property_description);
    $stmt->execute();
    $stmt->close();
    $response['success'] = true;
    $response['message'] = 'Property created successfully.';
    echo json_encode($response);
    exit;
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['message'] = 'Failed to create property.';
    echo json_encode($response);
    exit;
}