<?php
// Start the session to manage user authentication
session_start();
include('../config/config.php');
include('../config/checklogin.php');
include('../functions/create_notification.php');
check_login();

$response = ['success' => false];

if (!$_SESSION['user_id']) {
    $response['error'] = 'User not authenticated.';
    header('Content-Type: application/json');
    echo json_encode($response);
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to edit property', 1);
    exit;
}

// 2) Update property details
// Declare variables
$property_id = trim($_POST['property_id'] ?? '');
$property_name = trim($_POST['property_name'] ?? '');
$property_location = trim($_POST['property_location'] ?? '');
$property_description = trim($_POST['property_description'] ?? '');
$property_manager_id = trim($_POST['property_manager_id'] ?? '');

// Check if the property ID is valid
if (empty($property_id)) {
    $response['error'] = 'Invalid property ID.';
    $response['error'] = 'Property ID is required and cannot be empty.';
    echo json_encode($response);
     create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit property - missing property ID', 1);
    exit;
}

// Fetch current property details
$sql_check = "SELECT property_name, property_location, property_description, property_manager_id FROM properties WHERE property_id = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("i", $property_id);
$stmt_check->execute();
$stmt_check->bind_result($current_name, $current_location, $current_description, $current_manager_id);
$stmt_check->fetch();
$stmt_check->close();

// Check if any values have changed
if ($property_name !== $current_name || $property_location !== $current_location || $property_description !== $current_description || $property_manager_id !== $current_manager_id) {
    // SQL query
    $sql = "UPDATE properties SET property_name = ?, property_location = ?, property_description = ?, property_manager_id = ? WHERE property_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssii", $property_name, $property_location, $property_description, $property_manager_id, $property_id);

if (!$stmt->execute()) {
    $response['error'] = 'Failed to update property. Error: ' . $stmt->error;
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit property', 1);
    echo json_encode($response);
    exit;
}

$stmt->close();

$response['success'] = true;
$response['message'] = 'Property updated successfully.';
$response['updated_details'] = [
    'property_id' => $property_id,
    'property_name' => $property_name,
    'property_location' => $property_location,
    'property_description' => $property_description,
    'property_manager_id' => $property_manager_id
];
create_notification($mysqli, $_SESSION['user_id'], '3', 'Property edited successfully', 1);
echo json_encode($response);
exit;
    $stmt->close();
} else {
    $response['message'] = 'No changes detected. Property details remain the same.';
    create_notification($mysqli, $_SESSION['user_id'], '3', 'No changes made to property during edit', 1);
    echo json_encode($response);
    exit;
}

// Check if the update was successful
if ($stmt->error) {
    $response['error'] = 'Failed to update property. Error: ' . $stmt->error;
    create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit property', 1);
    echo json_encode($response);
    exit;
}

$stmt->close();

$response['success'] = true;
$response['message'] = 'Property updated successfully.';
create_notification($mysqli, $_SESSION['user_id'], '3', 'Property edited successfully', 1);
echo json_encode($response);
exit;