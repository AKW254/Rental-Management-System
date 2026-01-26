<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
include('../functions/create_notification.php');
check_login();
// Set response header  
ob_clean(); 
header('Content-Type: application/json; charset=utf-8');
$response = ['success' => false];
if (!$_SESSION['user_id']) {
    $response = ['success' => false,];
create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to maintenance functions', 1);
    echo json_encode($response);
    return;
}

// Handles the creation of a new maintenance request by validating inputs and inserting data into the database
if ($_POST['action'] === 'create') {
    $room_id = filter_var($_POST['room_id'], FILTER_VALIDATE_INT);
    $maintenance_request_description = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_description']);

    // Get agreement details
    $sql1 = "SELECT ra.agreement_id,us.user_name AS tenant_name,rm.room_title FROM rental_agreements AS ra
    INNER JOIN users AS us ON ra.tenant_id = us.user_id
    INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
     WHERE rm.room_id = ?";
    $stmt1 = $mysqli->prepare($sql1);
    $stmt1->bind_param("i", $room_id);
    if (!$stmt1->execute()) {
        error_log('Execute failed for agreement lookup: ' . $stmt1->error);
        $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request - agreement lookup error', 1);
        echo json_encode($response);
        exit;
    }
    $result1 = $stmt1->get_result();
    $res = $result1->fetch_assoc();

    if ($res) {  // FIXED: Check if agreement EXISTS
        $agreement_id = $res['agreement_id'];  
        $tenant_name = $res['tenant_name'];
        $room_title = $res['room_title'];

        // Get landlord details
        $sql2 = "SELECT pr.property_manager_id AS landlord_id,us.user_name AS property_manager_name,us.user_email AS property_manager_email  FROM rooms AS rs
         INNER JOIN properties AS pr ON rs.property_id = pr.property_id 
         INNER JOIN users AS us ON pr.property_manager_id = us.user_id
         WHERE room_id = ?";
        $stmt2 = $mysqli->prepare($sql2);
        $stmt2->bind_param("i", $room_id);
        if (!$stmt2->execute()) {
            error_log('Execute failed for landlord assignment: ' . $stmt2->error);
            $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request - landlord lookup error', 1);
            echo json_encode($response);
            exit;
        }
        $result2 = $stmt2->get_result();
        $res2 = $result2->fetch_assoc();

        if (!$res2) {
            $response = ['success' => false, 'message' => 'No landlord found for the selected room. Please contact support.'];
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request - no landlord found', 1);
            echo json_encode($response);
            exit;
        }

        $landlord_id = $res2['landlord_id'];  
        $property_manager_name = $res2['property_manager_name'];
        $property_manager_email = $res2['property_manager_email'];

        // Create the maintenance request
        $sql3 = "INSERT INTO maintenance_requests (agreement_id, maintenance_request_description, assigned_to) VALUES (?, ?, ?)";
        $stmt3 = $mysqli->prepare($sql3);
        if (!$stmt3) {
            error_log('Prepare failed for maintenance insert: ' . $mysqli->error);
            $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request - insert prepare error', 1);
            echo json_encode($response);
            exit;
        }
        $stmt3->bind_param("isi", $agreement_id, $maintenance_request_description, $landlord_id);
        // Send email notification to landlord
        include('../mailers/request_maintenance.php');
        if ($stmt3->execute() && $mail->send()) {
            
            $response = ['success' => true, 'message' => "Maintenance request created successfully"];
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Maintenance request created successfully', 1);
        } else {
            error_log('Database Error: ' . $mysqli->error);
            $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request', 1);
        }
    } else {
        $response = ['success' => false, 'message' => 'No active rental agreement found for this room.'];
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create maintenance request - no active agreement', 1);
    }

    echo json_encode($response);
    exit;
}


// Edit maintenance request
if ($_POST['action'] === 'edit_maintenance_request') {
   # Declare and sanitize inputs
    $maintenance_request_id = filter_var($_POST['maintenance_request_id'], FILTER_VALIDATE_INT);
    $maintenance_request_description = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_description']);
    $maintenance_request_status = mysqli_real_escape_string($mysqli, $_POST['maintenance_request_status']);
    /*Get Tenant Details */
    $sql="SELECT us.user_name AS tenant_name,us.user_email AS tenant_email,rs.room_title FROM maintenance_requests AS mr
    INNER JOIN rental_agreements AS ra ON mr.agreement_id = ra.agreement_id
    INNER JOIN rooms AS rs ON ra.room_id = rs.room_id
    INNER JOIN users AS us ON ra.tenant_id = us.user_id
    WHERE mr.maintenance_request_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $maintenance_request_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tenant = $result->fetch_assoc();
    $tenant_name = $tenant['tenant_name'];
    $tenant_email = $tenant['tenant_email'];
    $stmt = $mysqli->prepare("UPDATE maintenance_requests SET maintenance_request_description = ?, maintenance_request_status = ? WHERE maintenance_request_id = ?");
    $stmt->bind_param("ssi", $maintenance_request_description, $maintenance_request_status, $maintenance_request_id);
    if ($maintenance_request_status === 'Approved' && create_notification($mysqli, $_SESSION['user_id'], '3', 'Maintenance request approved', 1)) {
        include('../mailers/request_approval_maintenance.php');
    } elseif ($maintenance_request_status === 'Rejected') {
        include('../mailers/request_reject_maintenance.php');
    }
    if ($stmt->execute() || $mail->send() && create_notification($mysqli, $_SESSION['user_id'], '3', 'Maintenance request updated successfully', 1)) {
        $response = ['success' => true, 'message' => "Maintanance request updated successfully"];
        echo json_encode($response);
        exit;
    } else {
        error_log('Database Error: ' . $mysqli->error); // Log the detailed error
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to edit maintenance request', 1);
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
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to delete maintenance request - invalid ID', 1);
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
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to delete maintenance request - not found', 1);
        echo json_encode($response);
        exit;
    }

    // Proceed to delete the maintenance request
    $stmt = $mysqli->prepare("DELETE FROM maintenance_requests WHERE maintenance_request_id = ?");
    $stmt->bind_param("i", $maintenance_request_id);
    if ($stmt->execute()) {
        $response = ['success' => true, 'message' => "Maintenance request deleted successfully"];
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Maintenance request deleted successfully', 1);
        echo json_encode($response);
        exit;
    } else {
        $response = ['success' => false, 'message' => 'Error: ' . $mysqli->error];
        create_notification($mysqli,$_SESSION['user_id'],'3','Error: ' . $mysqli->error,1);
        echo json_encode($response);
        exit;
    }
}
