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

// Annual rent collected for each month
$sql = "SELECT
    DATE_FORMAT(months.month_start, '%Y-%m') AS month,
    COALESCE(SUM(p.payment_amount), 0) AS total_successful_payments
FROM
    (SELECT MAKEDATE(YEAR(CURDATE()), 1) + INTERVAL (n - 1) MONTH AS month_start
     FROM
         (SELECT @row := @row + 1 AS n
          FROM information_schema.columns,
               (SELECT @row := 0) r
          LIMIT 12) AS numbers
    ) AS months
LEFT JOIN
    payments AS p ON DATE_FORMAT(p.payment_created_at, '%Y-%m') = DATE_FORMAT(months.month_start, '%Y-%m')
                 AND p.payment_status = 'success'
WHERE
    YEAR(months.month_start) = YEAR(CURDATE())
GROUP BY
    month
ORDER BY
    month ASC;";  
$result = mysqli_query($mysqli, $sql);
$months = [];
$annual_rent_collected = [];
while ($row = mysqli_fetch_assoc($result)) {
    $month = $row['month'];
    $months[] = date('F', strtotime($month));
    $total_successful_payments = $row['total_successful_payments'];
    $annual_rent_collected[] = $total_successful_payments;
}
