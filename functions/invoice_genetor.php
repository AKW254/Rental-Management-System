<?php
// 3. Generate invoice PDF
include __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
// Initialize Dompdf
$dompdf = new Dompdf();
ob_start();
$html = '<!DOCTYPE html>

<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            border: 1px solid #ddd;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Rental Invoice</h2>
    <p><strong>Date:</strong>';
    $html .= $invoice_date;
    $html .='</p>
    </div>
    <table class="details">
        <tr>
            <th>Tenant Name</th>
            <td>';
            $html .= $tenant_name;
            $html .='</td>
        </tr>
        <tr>
            <th>Room</th>
            <td>';
            $html .= $room_name;
            $html .='</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>KSh ';
            $html .= number_format($invoice_amount, 2);
            $html .='</td>
        </tr>
        <tr>
            <th>Due Date</th>
            <td>';
            $html .= $invoice_due_date;
            $html .='</td>
        </tr>
    </table>
</body>

</html>';


$dompdf->loadHtml($html);
$dompdf->setPaper('A6', 'portrait');
$dompdf->render();

$dir = __DIR__ . '/../storage/invoices/';
if (!file_exists($dir)) {
    mkdir($dir, 0755, true);
}
$file_path = $dir . "invoice_{$agreement_id}_{$invoice_date}.pdf";
$file_name = "invoice_{$agreement_id}_{$invoice_date}.pdf";

$result = file_put_contents($file_path, $dompdf->output());

if ($result === false) {
    error_log("Failed to write PDF to: " . $file_path);
    die("Error: Could not save invoice PDF");
} else {
    error_log("PDF successfully saved to: " . $file_path);
}


file_put_contents($file_path, $dompdf->output());
// 4. Send email
include __DIR__ .'/../mailers/monthly_invoice.php';

