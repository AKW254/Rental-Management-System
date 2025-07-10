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
$sql = "SELECT rs.room_title,t.user_name AS requested_by,l.user_name AS requested_to,mr.maintenance_request_description,mr.maintenance_request_submitted_at,mr.maintenance_request_status,mr.maintenance_request_id FROM maintenance_requests AS mr INNER JOIN rental_agreements AS ra ON mr.agreement_id=ra.agreement_id
INNER JOIN rooms AS rs ON ra.room_id=rs.room_id INNER JOIN users AS t ON ra.tenant_id=t.user_id INNER JOIN users AS l ON mr.assigned_to = l.user_id;";

$result = $mysqli->query($sql);

if (!$result) {
    $response['error'] = 'Database query failed: ' . $mysqli->error;
    echo json_encode($response);
    exit;
}
$data = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $data[] = [
        'maintenanceRequestId'          => (int)   $row['maintenance_request_id'],
        'roomTitle'        => (string)$row['room_title'],
        'requestedBy'    => (string)$row['requested_by'],
        'requestedTo' => (string)$row['requested_to'],
        'maintenanceRequestDescription'         => (string)$row['maintenance_request_description'],
        'maintenanceRequestSubmittedAt'         => (string)$row['maintenance_request_submitted_at'],
        'maintenanceRequestStatus'         => (string)$row['maintenance_request_status'],
    ];
}

// 3) Return it as JSON
echo json_encode($data);