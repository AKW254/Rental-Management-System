<?php
 session_start();
 include('../config/config.php');
 include('../config/checklogin.php');
 include('../functions/create_notification.php');
 check_login();

// Set response header
ob_clean(); // Clean any accidental output buffer
header('Content-Type: application/json; charset=utf-8');
 $response = ['success' => false];
 if (!$_SESSION['user_id']) {
     $response = ['success' => false,];
     create_notification($mysqli, $_SESSION['user_id'], '3', 'Unauthorized access to rental agreements', 1);
     echo json_encode($response);
     return;
 }

// Create a new rental agreement
 if (isset($_POST['action']) && $_POST['action'] === 'create') {
     // Start secure handling
     mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 
     try {
         // Sanitize inputs
         $room_id = trim($_POST['room_id']);
         $tenant_id = $_SESSION['user_id'] ?? null;
         $agreement_no = "RA/" . rand(1000, 9999) . "/" . date("Y");
         $agreement_start_date = date('Y-m-d');

        // Check tenant ID is valid
        if (!$tenant_id) {
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create rental agreement - user session expired', 1);
            echo json_encode(['success' => false, 'message' => 'User session expired. Please login again.']);
            exit;
        }
 
         // Prevent duplicate agreements
         $check_sql = "SELECT 1 FROM rental_agreements WHERE room_id = ? AND tenant_id = ? AND agreement_status = 'Active'";
         $check_stmt = $mysqli->prepare($check_sql);
         $check_stmt->bind_param('ii', $room_id, $tenant_id);
         $check_stmt->execute();
         $check_stmt->store_result();

        // When duplicate agreement exists
        if ($check_stmt->num_rows > 0) {
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create rental agreement - duplicate active agreement', 1);
            $response['error'] = 'You already have an agreement for this room';
            ob_clean();
            echo json_encode($response);
            return;
        }
         $check_stmt->close();
 
         // Insert new agreement
         $insert_sql = "INSERT INTO rental_agreements (agreement_no, room_id, tenant_id,agreement_start_date) VALUES (?, ?, ?, ?)";
         $insert_stmt = $mysqli->prepare($insert_sql);
         $insert_stmt->bind_param('siis', $agreement_no, $room_id, $tenant_id, $agreement_start_date);
         $insert_stmt->execute();
         // Fetch related details for email
         $sql="SELECT rs.room_title, p.property_name, p.property_location, pm.user_name AS property_manager_name, pm.user_email AS property_manager_email, t.user_name AS tenant_name, ra.agreement_created_at FROM rental_agreements AS ra
         INNER JOIN rooms AS rs ON ra.room_id = rs.room_id 
            INNER JOIN properties AS p ON rs.property_id = p.property_id
            INNER JOIN users AS pm ON p.property_manager_id = pm.user_id
            INNER JOIN users AS t ON ra.tenant_id = t.user_id
            WHERE ra.agreement_no = ?";
            $mail_stmt = $mysqli->prepare($sql);
            $mail_stmt->bind_param('s', $agreement_no);
            $mail_stmt->execute();
            $mail_res = $mail_stmt->get_result();
            $mail_data = $mail_res->fetch_object();
            $property_manager_name = $mail_data->property_manager_name;
            $property_manager_email = $mail_data->property_manager_email;
            $tenant_name = $mail_data->tenant_name;
            $agreement_created_at= $mail_data->agreement_created_at;
            $room_title = $mail_data->room_title;
            $property_name = $mail_data->property_name;
            $property_location = $mail_data->property_location;
            $mail_stmt->close();
         //Notify property manager About new rental agreement
         include('../mailers/new_rental_agreement.php');
            $mail->send() && create_notification($mysqli, $_SESSION['user_id'], '1', 'New rental agreement created successfully', 1);
 
         echo json_encode([
             'success' => true,
             'message' => 'Rental agreement created successfully.',
             'agreement_no' => $agreement_no
         ]);
     } catch (mysqli_sql_exception $e) {
         $response= 'Database Error: ' . $e->getMessage();
         ob_clean();
         create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to create rental agreement', 1);   
            echo json_encode(['success' => false, 'message' => $response]);
            exit;
     }
 }


//Update a rental agreement
if ($_POST['action'] === 'edit_agreemet') {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $agreement_id = mysqli_real_escape_string($mysqli, $_POST['agreement_id']);
    $room_id = mysqli_real_escape_string($mysqli, $_POST['room_id']);
    $tenant_id = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);

    $sql = "UPDATE rental_agreements SET room_id = ?, tenant_id = ? WHERE agreement_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('isi', $room_id, $tenant_id, $agreement_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        create_notification($mysqli, $_SESSION['user_id'], '1', 'Rental agreement updated successfully', 1);
        $response = ['success' => true, 'message' => 'Rental agreement updated successfully.'];
    } else {
        create_notification($mysqli, $_SESSION['user_id'], '3', 'No changes made to rental agreement', 1);
        $response = ['success' => false, 'message' => 'Failed to update rental agreement or no changes made.'];
    }

    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


//Changing Status of a rental agreement
if ($_POST['action'] === 'change_agreement_status') {
    header('Content-Type: application/json');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $agreement_id = (int)($_POST['agreement_id'] ?? 0);
        $agreement_status = trim($_POST['agreement_status'] ?? '');

        if (!$agreement_id || !in_array($agreement_status, ['Active', 'Terminated'])) {
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to change rental agreement status - invalid input', 1);
            echo json_encode(['success' => false, 'message' => 'Invalid agreement ID or status.']);
            exit;
        }

        // Fetch agreement and room details once
        $info_query = "
            SELECT ra.room_id, ra.tenant_id, ra.agreement_start_date, ra.agreement_end_date,
                   rs.room_rent_amount AS room_rent, t.user_name AS tenant_name, 
                   t.user_email AS tenant_email, p.property_name, p.property_location
            FROM rental_agreements AS ra
            INNER JOIN rooms AS rs ON ra.room_id = rs.room_id
            INNER JOIN properties AS p ON rs.property_id = p.property_id
            INNER JOIN users AS t ON ra.tenant_id = t.user_id
            WHERE ra.agreement_id = ?
        ";
        $info_stmt = $mysqli->prepare($info_query);
        $info_stmt->bind_param('i', $agreement_id);
        $info_stmt->execute();
        $info_stmt->bind_result($room_id, $tenant_id, $agreement_start_date, $agreement_end_date, $room_rent, $tenant_name, $tenant_email, $property_name, $property_location);
        $info_stmt->fetch();
        $info_stmt->close();

        if (!$room_id) {
            create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to change rental agreement status - agreement not found', 1);
            echo json_encode(['success' => false, 'message' => 'Agreement not found.']);
            exit;
        }

        // --- Activate Agreement ---
        if ($agreement_status === 'Active') {
            $mysqli->begin_transaction();

            // Check room occupancy
            $check_stmt = $mysqli->prepare("SELECT agreement_id FROM rental_agreements WHERE room_id = ? AND agreement_status = 'Active' AND agreement_id != ?");
            $check_stmt->bind_param('ii', $room_id, $agreement_id);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $check_stmt->close();
                $mysqli->rollback();
                create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to activate rental agreement - room already occupied', 1);
                echo json_encode(['success' => false, 'message' => 'Room is already occupied by another active agreement.']);
                exit;
            }
            $check_stmt->close();

            // Update agreement
            $start_date = date('Y-m-d');
            $stmt = $mysqli->prepare("UPDATE rental_agreements SET agreement_status = ?, agreement_start_date = ? WHERE agreement_id = ?");
            $stmt->bind_param('ssi', $agreement_status, $start_date, $agreement_id);
            $stmt->execute();
            $stmt->close();

            // Update room
            $room_stmt = $mysqli->prepare("UPDATE rooms SET room_availability = 'Occupied' WHERE room_id = ?");
            $room_stmt->bind_param('i', $room_id);
            $room_stmt->execute();
            $room_stmt->close();

            // Send notification
            include('../mailers/agreement_activated.php');
            if (isset($mail)) $mail->send() && create_notification($mysqli, $_SESSION['user_id'], '1', 'Rental agreement activated successfully', 1)    ;

            $mysqli->commit();
        }

        // --- Terminate Agreement ---
        if ($agreement_status === 'Terminated') {
            $end_date = date('Y-m-d');

            $stmt = $mysqli->prepare("UPDATE rental_agreements SET agreement_status = ?, agreement_end_date = ? WHERE agreement_id = ?");
            $stmt->bind_param('ssi', $agreement_status, $end_date, $agreement_id);
            $stmt->execute();
            $stmt->close();

            // Update room availability
            $room_stmt = $mysqli->prepare("UPDATE rooms SET room_availability = 'Available' WHERE room_id = ?");
            $room_stmt->bind_param('i', $room_id);
            $room_stmt->execute();
            $room_stmt->close();
           
            // Send notification
            include('../mailers/agreement_terminated.php');
            if (isset($mail)) $mail->send() && create_notification($mysqli, $_SESSION['user_id'], '1', 'Rental agreement terminated successfully', 1);
        }
        $response = ['success' => true, 'message' => "Rental agreement status changed successfully."];
        ob_clean();
        echo json_encode($response);
        exit;
    } catch (Exception $e) {
      
        error_log("Agreement status change error: " . $e->getMessage());
        $mysqli->rollback();
        create_notification($mysqli, $_SESSION['user_id'], '3', 'Failed to change rental agreement status', 1);

        $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
        ob_clean();
        echo json_encode($response);
        exit;
    }

    exit;
}
