<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if(!$_SESSION['user_id']) {
   
    exit;
}

// 2) Query your properties + manager name
$sql = "
  SELECT
    p.property_id,
    p.property_name,
    p.property_location,
    p.property_description,
    u.user_name AS manager_name
  FROM properties AS p
  JOIN users AS u ON p.property_manager_id = u.user_id
  ORDER BY p.property_name ASC
";
$result = $mysqli->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $data[] = [
        'property_id'          => (int)   $row['property_id'],
        'property_name'        => (string)$row['property_name'],
        'property_location'    => (string)$row['property_location'],
        'property_description' => (string)$row['property_description'],
        'manager_name'         => (string)$row['manager_name'],
    ];
}

// 3) Return it as JSON
echo json_encode($data);