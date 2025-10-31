<?php
require_once '../config/config.php';
require("../config/daraja.php");

$callbackData = file_get_contents('php://input');
$data = json_decode($callbackData, true);

file_put_contents('../storage/logs/mpesa_callback_' . time() . '.json', $callbackData);

if (!isset($data['Body']['stkCallback'])) {
    http_response_code(400);
    echo json_encode(['status' => 'fail', 'message' => 'Invalid callback']);
    exit;
}

$stkCallback = $data['Body']['stkCallback'];
$resultCode = $stkCallback['ResultCode'] ?? -1;
$resultDesc = $stkCallback['ResultDesc'] ?? 'Unknown';

if ($resultCode == 0 && isset($stkCallback['CallbackMetadata']['Item'])) {
    $metadata = $stkCallback['CallbackMetadata']['Item'];

    $amount = $receipt = $phone = $txnDate = $invoice_number = '';

    foreach ($metadata as $item) {
        if ($item['Name'] == "Amount") $amount = $item['Value'];
        if ($item['Name'] == "MpesaReceiptNumber") $receipt = $item['Value'];
        if ($item['Name'] == "TransactionDate") $txnDate = $item['Value'];
        if ($item['Name'] == "PhoneNumber") $phone = $item['Value'];
    }

    /* Get Invoice ID From Callback URL */
    $invoice_id = $_GET['invoice_id'];
    if ($invoice_id) {
        // Insert into payments table
        $method = 'MPESA';
        $payment_date = date('Y-m-d', strtotime(substr($txnDate, 0, 8)));
       $payment_method = 'Mpesa';

        $sql_payment = "INSERT INTO payments (invoice_id, payment_date, payment_amount, payment_method, payment_transaction_id) VALUES (?, ?, ?, ?, ?)";
        $stmt_payment = $mysqli->prepare($sql_payment);
        if ($stmt_payment) {
            $stmt_payment->bind_param("issss", $invoice_id, $payment_date, $amount, $payment_method, $receipt);
            $payment_success = $stmt_payment->execute();
            $stmt_payment->close();
        }

        if ($payment_success) {
            // Update invoice status to 'Paid'
            $sql_update_invoice = "UPDATE invoices SET invoice_status = 'Paid' WHERE invoice_id = ?";
            $stmt_update_invoice = $mysqli->prepare($sql_update_invoice);
            if ($stmt_update_invoice) {
                $stmt_update_invoice->bind_param("i", $invoice_id);
                $stmt_update_invoice->execute();
                $stmt_update_invoice->close();
            }
        }
    }else{
        file_put_contents('../storage/logs/invoice_match_failed_' . time() . '.log', json_encode($stkCallback));
        echo json_encode([
            'ResultCode' => 1,
            'ResultDesc' => 'Invoice not found for AccountReference'
        ]);
    }} else {                               
    // Log failed transaction
    file_put_contents('../storage/logs/mpesa_failed_' . time() . '.log', json_encode($stkCallback));
    http_response_code(200);
    echo json_encode([
        'ResultCode' => 1,
        'ResultDesc' => 'Transaction failed: ' . $resultDesc
    ]);
}