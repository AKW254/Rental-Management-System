<?php

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Get all active leases
$sql = "SELECT 
            ra.agreement_id, ra.tenant_id, 
            rm.room_name, rm.room_rent_amount,
            t.user_name, t.user_email
        FROM rental_agreements AS ra
        INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
        INNER JOIN users AS t ON ra.tenant_id = t.user_id
        WHERE ra.agreement_status = 'Active'";
        
$result = $mysqli->query($sql);



while ($row = $result->fetch_assoc()) {
    $agreement_id = $row['agreement_id'];
    $tenant_name = $row['user_name'];
    $tenant_email = $row['user_email'];
    $room_name = $row['room_name'];
    $invoice_amount = $row['room_rent_amount'];
    $invoice_date = date('Y-m-d');
    $invoice_due_date = date('Y-m-d', strtotime('+15 days'));

    // 3. Generate invoice PDF
    $dompdf = new Dompdf($options);
    ob_start();
    ?>
    <html>
    <head><style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { text-align:center; margin-bottom:20px; }
        .details { width:100%; border-collapse:collapse; }
        .details th, .details td { border:1px solid #ddd; padding:8px; }
    </style></head>
    <body>
    <div class="header">
        <h2>Rental Invoice</h2>
        <p><strong>Date:</strong> <?= $invoice_date ?></p>
    </div>
    <table class="details">
        <tr><th>Tenant Name</th><td><?= $tenant_name ?></td></tr>
        <tr><th>Room</th><td><?= $room_name ?></td></tr>
        <tr><th>Amount</th><td>KSh <?= number_format($invoice_amount, 2) ?></td></tr>
        <tr><th>Due Date</th><td><?= $invoice_due_date ?></td></tr>
    </table>
    </body></html>
    <?php
    $html = ob_get_clean();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Save to file (temporarily)
    $file_path = "../storage/invoices/invoice_{$agreement_id}.pdf";
    file_put_contents($file_path, $dompdf->output());
    // 4. Send email
    include('../maillers/monthly_invoice.php');
}