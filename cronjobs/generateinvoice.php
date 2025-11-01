<?php
//Generate Invoices for all active leases
include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/config.php';



//Get all active leases
$sql="SELECT ra.agreement_id,rm.room_rent_amount AS invoice_amount FROM rental_agreements AS ra INNER JOIN rooms AS rm ON ra.room_id = rm.room_id WHERE ra.agreement_status ='Active'";
$res=$mysqli->query($sql);
while($row=$res->fetch_object()) {
    $agreement_id=$row->agreement_id;
    $invoice_amount=$row->invoice_amount;
    $invoice_date=date('Y-m-d');
    $invoice_due_date=date('Y-m-d', strtotime($invoice_date. ' + 15 days'));

    //Insert invoice
    $stmt=$mysqli->prepare("INSERT INTO invoices (agreement_id, invoice_date, invoice_due_date, invoice_amount, invoice_status) VALUES (?,?,?,?, 'Unpaid')");
    $stmt->bind_param("isss",$agreement_id,$invoice_date,$invoice_due_date,$invoice_amount);
    $stmt->execute();
    $stmt->close();
}