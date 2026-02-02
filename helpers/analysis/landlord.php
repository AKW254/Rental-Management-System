<?php

//Number of Properties
$properties_sql= "SELECT COUNT(*) AS total FROM properties WHERE property_manager_id = ?";
$properties_stmt = $mysqli->prepare($properties_sql);
$properties_stmt->bind_param('i',$_SESSION['user_id']);
$properties_stmt->execute();
$result_properties = $properties_stmt->get_result();
$row_properties = $result_properties->fetch_assoc();

$no_of_properties = $row_properties['total'];

//Number of Room
$rooms_sql = "SELECT COUNT(*) AS total FROM properties AS ps
INNER JOIN rooms AS rs ON ps.property_id = rs.property_id
 WHERE property_manager_id = ?";
$rooms_stmt = $mysqli->prepare($rooms_sql);
$rooms_stmt->bind_param('i', $_SESSION['user_id']);
$rooms_stmt->execute();
$result_rooms = $rooms_stmt->get_result();
$row_rooms = $result_rooms->fetch_assoc();

$no_of_rooms = $row_rooms['total'];

//Active Agreements
$agreements_sql = "SELECT COUNT(*) AS total FROM rental_agreements AS ra
INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
INNER JOIN properties AS ps ON rm.property_id = ps.property_id
 WHERE ps.property_manager_id = ? AND ra.agreement_status = 'Active'";
 $agreement_stmt = $mysqli->prepare($agreements_sql);
 $agreement_stmt->bind_param('i', $_SESSION['user_id']);
    $agreement_stmt->execute();
    $result_agreements = $agreement_stmt->get_result();
    $row_agreements = $result_agreements->fetch_assoc();
    $total_agreements = $row_agreements['total'];
    //Pending Maintenance
$maintenance_sql = "SELECT COUNT(*) AS total FROM maintenance_requests AS mr
INNER JOIN rental_agreements AS ra ON mr.agreement_id = ra.agreement_id
INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
INNER JOIN properties AS ps ON rm.property_id = ps.property_id
 WHERE ps.property_manager_id = ? AND mr.maintenance_request_status = 'submitted'";
 $maintenance_stmt = $mysqli->prepare($maintenance_sql);
 $maintenance_stmt->bind_param('i', $_SESSION['user_id']);
    $maintenance_stmt->execute();
    $result_maintenance = $maintenance_stmt->get_result();
    $row_maintenance = $result_maintenance->fetch_assoc();
    $total_maintenance = $row_maintenance['total'];
    //Total Tenants
$tenants_sql = "SELECT COUNT(*) AS total FROM users AS us
INNER JOIN rental_agreements AS ra ON us.user_id = ra.tenant_id
INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
INNER JOIN properties AS ps ON rm.property_id = ps.property_id
 WHERE ps.property_manager_id = ? AND us.role_id = 3";
 $tenants_stmt = $mysqli->prepare($tenants_sql);
 $tenants_stmt->bind_param('i', $_SESSION['user_id']);
    $tenants_stmt->execute();
    $result_tenants = $tenants_stmt->get_result();
    $row_tenants = $result_tenants->fetch_assoc();
    $total_tenants = $row_tenants['total'];

//Revenue
$Revenue_sql = "SELECT SUM(inv.invoice_amount) AS total FROM invoices AS inv
INNER JOIN rental_agreements AS ra ON inv.agreement_id = ra.agreement_id
INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
INNER JOIN properties AS ps ON rm.property_id = ps.property_id
 WHERE ps.property_manager_id = ? AND inv.invoice_status = 'Paid'";
 $Revenue_stmt = $mysqli->prepare($Revenue_sql);
 $Revenue_stmt->bind_param('i', $_SESSION['user_id']);
    $Revenue_stmt->execute();
    $result_Revenue = $Revenue_stmt->get_result();
    $row_Revenue = $result_Revenue->fetch_assoc();
    $revenue_collected_per_landlord = $row_Revenue['total'];    
