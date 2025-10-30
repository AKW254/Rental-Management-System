<?php
// Start the session to manage user authentication
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();

$response = ['success' => false];

if (!$_SESSION['user_id']) {
    $response['error'] = 'User not authenticated.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// 2) Create a new invoice
if(isset($_POST['action']) && $_POST['action'] === 'create_invoice') {
    // Declare variables
    $agreement_id = trim($_POST['agreement_id'] ?? '');
    $invoice_date = date('Y-m-d');
    $invoice_due_date = trim($_POST['invoice_due_date'] ?? '');
    //Check room rent amount
    $sql_rent = "SELECT rm.room_rent_amount AS rent_amount FROM rental_agreements AS ra JOIN rooms AS rm ON ra.room_id = rm.room_id WHERE agreement_id = ?";
    $stmt_rent = $mysqli->prepare($sql_rent);
    $stmt_rent->bind_param("i", $agreement_id);
    $stmt_rent->execute();
    $result_rent = $stmt_rent->get_result();

    if ($result_rent && $row_rent = $result_rent->fetch_assoc()) {
        $invoice_amount = $row_rent['rent_amount'];
    } else {
        $response['error'] = 'Failed to retrieve room rent amount.';
        echo json_encode($response);
        exit;
    }

    // SQL query
    $sql = "INSERT INTO invoices (agreement_id, invoice_date, invoice_due_date, invoice_amount, invoice_status) VALUES (?, ?, ?, ?, 'Unpaid')";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isss", $agreement_id, $invoice_date, $invoice_due_date, $invoice_amount);

    if (!$stmt->execute()) {
        $response['error'] = 'Failed to create invoice. Error: ' . $stmt->error;
        echo json_encode($response);
        exit;
    }

    $stmt->close();

    $response['success'] = true;
    $response['message'] = 'Invoice created successfully.';
    echo json_encode($response);
    exit;
}

// 3) Edit an invoice
if(isset($_POST['action']) && $_POST['action'] === 'edit_invoice') {
    // Declare variables
    $invoice_id = trim($_POST['invoice_id'] ?? '');
    $invoice_amount = trim($_POST['invoice_amount'] ?? '');
    $invoice_due_date = trim($_POST['invoice_due_date'] ?? '');

    // SQL query
    $sql = "UPDATE invoices SET invoice_amount = ?, invoice_due_date = ? WHERE invoice_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $invoice_amount, $invoice_due_date, $invoice_id);

    if (!$stmt->execute()) {
        $response['error'] = 'Failed to update invoice. Error: ' . $stmt->error;
        echo json_encode($response);
        exit;
    }

    $stmt->close();

    $response['success'] = true;
    $response['message'] = 'Invoice updated successfully.';
    echo json_encode($response);
    exit;
}           