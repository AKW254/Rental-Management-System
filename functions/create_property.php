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
    //get propertyid and sent with response
    $property_id = $mysqli->insert_id;
    $stmt = $mysqli->prepare("SELECT pr.property_id,pr.property_name,pr.property_location,pr.property_description,pr.property_manager_id,pm.user_name,pm.user_email FROM properties AS pr
     JOIN users AS pm ON pr.property_manager_id = pm.user_id WHERE property_id = ?");
    $stmt->bind_param("s", $property_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();
    $stmt->close();
    //Check if property was created successfully
    if (!$property) {
        $response['error'] = 'Failed to create property.';
        echo json_encode($response);
        exit;
    }
    //send property details with response
    $response['property_id'] = $property_id;
    $response['property_name'] = $property_name;
    $response['property_location'] = $property_location;
    $response['property_description'] = $property_description;
    $response['property_manager_id'] = $property_manager_id;
    $property_manager_name = $property['user_name'];
    $property_manager_email = $property['user_email'];
    //Mail notification to property manager
    
   include('../mailers/property_onboarding.php');
    $mail->send();
    //Send propertyid with response
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