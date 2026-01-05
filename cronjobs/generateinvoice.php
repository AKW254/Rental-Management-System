<?php
//Generate Invoices for all active leases
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/config.php';

//Get all active leases
$sql= "SELECT ra.agreement_id, t.user_name, t.user_email, rm.room_title,rm.room_rent_amount AS invoice_amount FROM rental_agreements AS ra 
INNER JOIN rooms AS rm ON ra.room_id = rm.room_id 
INNER JOIN users AS t ON ra.tenant_id = t.user_id 
WHERE ra.agreement_status ='Active'";
$res=$mysqli->query($sql);
while($row=$res->fetch_object()) {
    $agreement_id = $row->agreement_id;
    $tenant_name = $row->user_name;
    $tenant_email = $row->user_email;
    $room_name = $row->room_title;
    $invoice_amount = $row->invoice_amount;
    $invoice_date = date('Y-m-d');
    $invoice_due_date = date('Y-m-d', strtotime('+15 days'));
    echo "Generating invoice for Agreement ID: $agreement_id, Tenant: $tenant_name, Tenant_email: $tenant_email, Amount: $invoice_amount\n";
    //Insert invoice
    $stmt=$mysqli->prepare("INSERT INTO invoices (agreement_id, invoice_date, invoice_due_date, invoice_amount, invoice_status) VALUES (?,?,?,?, 'Unpaid')");
    $stmt->bind_param("isss",$agreement_id,$invoice_date,$invoice_due_date,$invoice_amount);
    $stmt->execute();
    $stmt->close();
    //Generate Invoice PDF
    include __DIR__ . '/../functions/invoice_genetor.php';


}