<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header
header('Content-Type: application/json');
$response = ['success' => false];
if (!$_SESSION['user_id']) {

    exit;
}


//Get Rental Agreements a row data
$sql= "SELECT rm.room_title,pm.property_name,u.user_name AS tenant_name,u2.user_name AS landlord_name,ra.agreement_id,ra.agreement_start_date,ra.agreement_end_date,ra.agreement_status FROM rental_agreements ra
INNER JOIN rooms rm ON ra.room_id=rm.room_id
INNER JOIN properties pm ON rm.property_id=pm.property_id
INNER JOIN users u ON ra.tenant_id=u.user_id
INNER JOIN users u2 ON pm.property_manager_id=u2.user_id ORDER BY agreement_created_at DESC";

// 2) Query your Rental Agreements with property name
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database prepare failed: ' . $mysqli->error]);
    $mysqli->close();
    exit;
}
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database execute failed: ' . $stmt->error]);
    $stmt->close();
    $mysqli->close();
    exit;
}
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    // Ensure correct typing if you care
    $data[] = [
        'agreementId' => (int)$row['agreement_id'],
        'roomTitle' => (string)$row['room_title'],
        'propertyName' => (string)$row['property_name'],
        'tenantName' => (string)$row['tenant_name'],
        'landlordName' => (string)$row['landlord_name'],
        'agreementStartDate' => (string)$row['agreement_start_date'],
        'agreementEndDate' => (string)$row['agreement_end_date'],
        'agreementStatus' => (string)$row['agreement_status']
    ];
}
// 3) Return it as JSON
echo json_encode($data);
$stmt->close();
$mysqli->close();
