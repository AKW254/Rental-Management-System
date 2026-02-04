<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login()
//Check if user is logged in

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>

<body class="sidebar-icon-only sidebar-fixed">
    <div class="container-scroller">

        <!-- partial:partials/_sidebar.html -->
        <?php include('../partials/sidebar.php') ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <?php include('../partials/navbar.php') ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">Tenants </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">LandLord Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tenants</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th> #</th>
                                                    <th>Tenant Name</th>
                                                    <th>Tenant Email</th>
                                                    <th>Room No </th>
                                                    <th>Property Name</th>
                                                    <th>Since</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = '0';
                                                $sql = "SELECT us.user_id,us.user_name AS tenant_name,us.user_email AS tenant_email,rm.room_title AS tenant_room,ps.property_name AS tenant_property,ra.agreement_start_date AS tenant_since FROM users AS us 
                                                        INNER JOIN roles AS rs ON us.role_id = rs.role_id 
                                                        INNER JOIN rental_agreements AS ra ON us.user_id = ra.tenant_id
                                                        INNER JOIN rooms AS rm ON ra.room_id = rm.room_id
                                                        INNER JOIN properties AS ps ON rm.property_id = ps.property_id 
                                                        WHERE ps.property_manager_id = '{$_SESSION['user_id']}' AND us.role_id = 3";
                                                $stmt = $mysqli->query($sql);
                                                if ($stmt->num_rows > 0) {
                                                    while ($row = $stmt->fetch_assoc()) {
                                                        $count = $count + 1;

                                                ?>
                                                        <tr data-user-id="<?= $row['user_id'] ?>">
                                                            <td><?php echo $count; ?></td>
                                                            <td>
                                                                <?php echo $row['tenant_name'] ?>
                                                            </td>
                                                            <td><?php echo $row['tenant_email'] ?></td>
                                                            <td><?php echo $row['tenant_room'] ?></td>
                                                            <td><?php echo $row['tenant_property'] ?></td>
                                                            <td><?php echo date('d M Y', strtotime($row['tenant_since'])) ?></td>
                                                        </tr>
                                                <?php }
                                                } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main-panel ends -->
                <!-- container-scroller -->
                <?php include('../functions/custom_alerts.php'); ?>
                <script src="../public/assets/vendors/modal/modal-demo.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/data-table.js"></script>

                <?php include('../partials/scripts.php') ?>


</body>



</html>