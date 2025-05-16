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

// 2) Query your Rooms  with property name
$sql = "SELECT rm.room_id,rm.room_title,rm.room_rent_amount,rm.room_availability, py.property_name AS property_name 
FROM rooms AS rm INNER JOIN properties AS py ON rm.property_id = py.property_id ";

$result = $mysqli->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $data[] = [
    'room_id'          => (int)   $row['room_id'],
    'room_title'        => (string)$row['room_title'],
    'room_rent_amount'    => (string)$row['room_rent_amount'],
    'room_availability' => (string)$row['room_availability'],
    'property_name'         => (string)$row['property_name'],
    ];
}

// 3) Return it as JSON
echo json_encode($data);