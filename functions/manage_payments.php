<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // set to 1 if debugging locally

session_start();
include('../config/config.php');
$config = include('../config/config.php');
include('../config/checklogin.php');
require_once('../config/daraja.php');
$daraja = new Daraja($config);

check_login();
ob_clean();
header('Content-Type: application/json');

$response = ['success' => false];

if (!$_SESSION['user_id']) {
    $response['error'] = 'User not authenticated.';
    echo json_encode($response);
    exit;
}
// 4) Process a payment
if (isset($_POST['action']) && $_POST['action'] === 'pay_invoice') {
    header('Content-Type: application/json');

    $invoice_id = trim($_POST['invoice_id'] ?? '');
    $payment_date = date('Y-m-d');
    $payment_amount = trim($_POST['payment_amount'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');
    $phone = trim($_POST['mpesa_phone'] ?? '');
    

    // Validate inputs
    if (empty($invoice_id) || empty($payment_amount) || empty($payment_method)) {
        echo json_encode(['error' => 'Missing required fields.']);
        exit;
    }

    if ($payment_method === 'Cash' || $payment_method === 'Bank Transfer') {
        $sql_payment = "INSERT INTO payments (invoice_id, payment_date, payment_amount, payment_method) VALUES (?, ?, ?, ?)";
        $stmt_payment = $mysqli->prepare($sql_payment);

        if ($stmt_payment) {
            $stmt_payment->bind_param("isss", $invoice_id, $payment_date, $payment_amount, $payment_method);
            $payment_success = $stmt_payment->execute();
            $stmt_payment->close();
        }
    } elseif ($payment_method === 'Mpesa') {
        $invoice_number = $invoice_id; // ✅ fix undefined variable

        $payment = $daraja->lipaNaMpesaOnline([
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => '1', 
            'PartyA' => $phone,
            'PhoneNumber' => $phone,
            'CallBackURL' => $config['callbackUrl'] . '?invoice_id=' . $invoice_id,
            'AccountReference' => $invoice_number,
            'TransactionDesc' => 'Payment for Invoice ' . $invoice_number,
        ]);

        if (isset($payment['ResponseCode']) && $payment['ResponseCode'] === '0') {
            echo json_encode([
                'success' => true,
                'stk_push' => true,
                'message' => 'STK Push Sent! Check your phone to complete payment.'
            ]);
            exit;
        } else {
            echo json_encode([
                'error' => 'M-Pesa payment failed: ' . ($payment['errorMessage'] ?? 'Please try again.')
            ]);
            exit;
        }
    
} else {
        echo json_encode(['error' => 'Invalid payment method.']);
        exit;
    }

    if (!$payment_success) {
        echo json_encode(['error' => 'Failed to process payment.']);
        exit;
    }

    // Update invoice status
    $sql_update_invoice = "UPDATE invoices SET invoice_status = 'Paid' WHERE invoice_id = ?";
    $stmt_update_invoice = $mysqli->prepare($sql_update_invoice);

    if ($stmt_update_invoice) {
        $stmt_update_invoice->bind_param("i", $invoice_id);
        if (!$stmt_update_invoice->execute()) {
            echo json_encode(['error' => 'Failed to update invoice: ' . $stmt_update_invoice->error]);
            exit;
        }
        $stmt_update_invoice->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare invoice update statement.']);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Payment processed successfully.'
    ]);
    exit;
}
