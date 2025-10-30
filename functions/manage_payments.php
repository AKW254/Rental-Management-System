<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
ob_clean();
header('Content-Type: application/json');

$response = ['success' => false];

if (!$_SESSION['user_id']) {
    $response['error'] = 'User not authenticated.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
// 4) Process a payment
if (isset($_POST['action']) && $_POST['action'] === 'pay_invoice') {
    // Declare variables
    $invoice_id = trim($_POST['invoice_id'] ?? '');
    $payment_date = date('Y-m-d');
    $payment_amount = trim($_POST['payment_amount'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');

    $stmt_payment = null;
    $payment_success = false;

    if ($payment_method === 'Cash' || $payment_method === 'Bank Transfer') {
        $sql_payment = "INSERT INTO payments (invoice_id, payment_date, payment_amount, payment_method) VALUES (?, ?, ?, ?)";
        $stmt_payment = $mysqli->prepare($sql_payment);
        if ($stmt_payment) {
            $stmt_payment->bind_param("isss", $invoice_id, $payment_date, $payment_amount, $payment_method);
            $payment_success = $stmt_payment->execute();
        }
    } elseif ($payment_method === 'Mpesa') {
        $mpesa_phone = trim($_POST['mpesa_phone'] ?? '');
        $sql_payment = "INSERT INTO payments (invoice_id, payment_date, payment_amount, payment_method, mpesa_phone) VALUES (?, ?, ?, ?, ?)";
        $stmt_payment = $mysqli->prepare($sql_payment);
        if ($stmt_payment) {
            $stmt_payment->bind_param("issss", $invoice_id, $payment_date, $payment_amount, $payment_method, $mpesa_phone);
            $payment_success = $stmt_payment->execute();
        }
    } else {
        $response['error'] = 'Invalid payment method.';
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    

    if (!$payment_success) {
        $response['error'] = 'Failed to process payment. Error: ' . ($stmt_payment ? $stmt_payment->error : 'Statement preparation failed.');
        echo json_encode($response);
        exit;
    }

    // Update invoice status to 'Paid'
    $sql_update_invoice = "UPDATE invoices SET invoice_status = 'Paid' WHERE invoice_id = ?";
    $stmt_update_invoice = $mysqli->prepare($sql_update_invoice);
    if ($stmt_update_invoice) {
        $stmt_update_invoice->bind_param("i", $invoice_id);
        if (!$stmt_update_invoice->execute()) {
            $response['error'] = 'Failed to update invoice status. Error: ' . $stmt_update_invoice->error;
            echo json_encode($response);
            exit;
        }
        $stmt_update_invoice->close();
    } else {
        $response['error'] = 'Failed to prepare invoice update statement.';
        echo json_encode($response);
        exit;
    }
    if ($stmt_payment !== null) {
        $stmt_payment->close();
    }


    $response['success'] = true;
    $response['message'] = 'Payment processed successfully.';
    echo json_encode($response);
    exit;
}