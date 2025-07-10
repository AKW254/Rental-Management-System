<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header   
header('Content-Type: application/json; charset=utf-8');
$response = ['success' => false];
if (!$_SESSION['user_id']) {
    $response = ['success' => false,];
    echo json_encode($response);
    return;
}

// Handles the creation of a new maintenance request by validating inputs and inserting data into the database
if ($_POST['action'] === 'create') {
    //Declare variables
    $room_id = mysqli_real_escape_string($mysqli, $_POST['room_id']);
    $maintenance_request_description = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_description']);
    //Get agreement details
    $sql1="SELECT agreement_id FROM rental_agreements WHERE room_id = ?";
    $stmt1 = $mysqli->prepare($sql1);
    $stmt1->bind_param("i", $room_id);
    $stmt1->execute();  
    $stmt1->bind_result($agreement_id);
    $stmt1->fetch();
    $stmt1->close();
    //Assign to landlord
    $sql2="SELECT us.user_id FROM users AS us INNERJOIN properties as ps ON us.user_id = ps.property_manager_id INNERJOIN rooms AS rm ON ps.property_id = rm.property_id WHERE rm.room_id = ?";
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param("i", $room_id);
    $stmt2->execute();
    $stmt2->bind_result($landlord_id);
    $stmt2->fetch();
    $stmt2->close();
    //Insert maintenance request
    $stmt = $mysqli->prepare("INSERT INTO maintenance_requests (agreement_id,maintenance_request_description,assigned_to 	)
     VALUES (?, ?)");
    $stmt->bind_param("isi", $agreement_id,$maintenance_request_description,$landlord_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => "Maintenance request created successfully"];
        echo json_encode($response);
        exit;
    } else {
        error_log('Database Error: ' . $mysqli->error); // Log the detailed error
        $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
        echo json_encode($response);
        exit;

    }
}
// Edit maintenance request
if ($_POST['action'] === 'edit_maintenance_request') {
    //Declare variables
    $maintenance_request_id = filter_var($_POST['maintenance_request_id'], FILTER_VALIDATE_INT);
    $maintenance_request_description = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_description']);
    $maintenance_request_status = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_status']);
    $stmt = $mysqli->prepare("UPDATE maintenance_requests SET maintenance_request_description = ?, maintenance_request_status = ? WHERE maintenance_request_id = ?");
    $stmt->bind_param("ssi", $maintenance_request_description, $maintenance_request_status, $maintenance_request_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => "Maintanance request updated successfully"];
        echo json_encode($response);
        exit;
    } else {
        error_log('Database Error: ' . $mysqli->error); // Log the detailed error
        $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
        echo json_encode($response);
        exit;
    }
}

// Delete room
if ($_POST['action'] === 'delete_request') {
    $maintenance_request_id = filter_var($_POST['maintenance_request_id'], FILTER_VALIDATE_INT);
    if ($maintenance_request_id === false) {
        $response['error'] = 'Invalid Maintenance Request ID';
        echo json_encode($response);
        exit;
    }
    // Check if the maintenance request exists
    $check_stmt = $mysqli->prepare("SELECT maintenance_request_id FROM maintenance_requests WHERE maintenance_request_id = ?");
    $check_stmt->bind_param("i", $maintenance_request_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    if ($check_result->num_rows === 0) {
        $response = ['success' => false, 'message' => 'Maintenance request not found.'];
        echo json_encode($response);
        exit;
    }

    // Proceed to delete the maintenance request
    $stmt = $mysqli->prepare("DELETE FROM maintenance_requests WHERE maintenance_request_id = ?");
    $stmt->bind_param("i", $maintenance_request_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => "Maintenance request deleted successfully"];
        echo json_encode($response);
        exit;
    } else {
        $response = ['success' => false, 'message' => 'Error: ' . $mysqli->error];
        echo json_encode($response);
        exit;
    }
}
