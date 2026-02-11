<?php

// number of rented rooms
$rooms_sql = "SELECT COUNT(*) AS total FROM rental_agreements AS ra
WHERE ra.tenant_id = '{$_SESSION['user_id']}' AND ra.agreement_status = 'Active'";
$rooms_stmt = $mysqli->prepare($rooms_sql);
$rooms_stmt->execute();
$result_rooms = $rooms_stmt->get_result();
$row_rooms = $result_rooms->fetch_assoc();
$total_rooms = $row_rooms['total'];

//Active Agreements
$agreements_sql = "SELECT COUNT(*) AS total FROM rental_agreements AS ra
WHERE ra.tenant_id = '{$_SESSION['user_id']}' AND ra.agreement_status = 'Active'";
$agreement_stmt = $mysqli->prepare($agreements_sql);
$agreement_stmt->execute();
$result_agreements = $agreement_stmt->get_result();
$row_agreements = $result_agreements->fetch_assoc();
$total_agreements = $row_agreements['total'];
//Pending Maintenance
$maintenance_sql = "SELECT COUNT(*) AS total FROM maintenance_requests AS mr
INNER JOIN rental_agreements AS ra ON mr.agreement_id = ra.agreement_id
WHERE ra.tenant_id = '{$_SESSION['user_id']}' AND mr.maintenance_request_status = 'submitted'"; 
$maintenance_stmt = $mysqli->prepare($maintenance_sql);
$maintenance_stmt->execute();
$result_maintenance = $maintenance_stmt->get_result();
$row_maintenance = $result_maintenance->fetch_assoc();
$total_maintenance = $row_maintenance['total'];

//Total Rental remmitances
$remittances_sql = "SELECT SUM(inv.invoice_amount) AS total FROM invoices AS inv
INNER JOIN rental_agreements AS ra ON inv.agreement_id = ra.agreement_id
WHERE ra.tenant_id = '{$_SESSION['user_id']}' AND inv.invoice_status = 'Paid'";
$agreement_stmt = $mysqli->prepare($remittances_sql);
$agreement_stmt->execute();
$result_remittances = $agreement_stmt->get_result();
$row_remittances = $result_remittances->fetch_assoc();
$total_remittances = $row_remittances['total'];

