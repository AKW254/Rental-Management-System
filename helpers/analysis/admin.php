<?php
//No of properties check for dublicate
 $sql = "SELECT COUNT(*) AS total FROM properties";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
  $total_properties = $row['total'];

  //No of rooms check for dublicate
    $sql = "SELECT COUNT(*) AS total FROM rooms";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
  $total_rooms = $row['total'];

//No of active agreements  check for dublicate
$sql = "SELECT COUNT(*) AS total FROM rental_agreements WHERE agreement_status = 'active'";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
    $total_agreements = $row['total'];  

//No of pending maintenance check for dublicate
$sql = "SELECT COUNT(*) AS total FROM maintenance_requests WHERE maintenance_request_status = 'submitted' OR maintenance_request_status = 'in progress'";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
    $total_maintenance = $row['total'];
//Registered Tenants check for dublicate
$sql = "SELECT COUNT(*) AS total FROM users AS us INNER JOIN roles AS ro ON ro.role_id=us.role_id WHERE ro.role_type='Tenant'";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
    $total_tenants = $row['total'];
//Total Landlords check for dublicate
$sql = "SELECT COUNT(*) AS total FROM users AS us INNER JOIN roles AS ro ON ro.role_id=us.role_id WHERE ro.role_type='Landlord'";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
    $total_landlords = $row['total'];
//Total Admin check for dublicate
$sql = "SELECT COUNT(*) AS total FROM users AS us INNER JOIN roles AS ro ON ro.role_id=us.role_id WHERE ro.role_type='administrator'";
  $result = mysqli_query($mysqli, $sql);
  $row = mysqli_fetch_assoc($result);
    $total_admin = $row['total'];

//chart data
// Ensure variables are properly set and valid integers
$total_admin = isset($total_admin) && is_numeric($total_admin) ? (int)$total_admin : 0;
$total_tenants = isset($total_tenants) && is_numeric($total_tenants) ? (int)$total_tenants : 0;
$total_landlords = isset($total_landlords) && is_numeric($total_landlords) ? (int)$total_landlords : 0;

