<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login();
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
                        <h3 class="page-title"> Notifications </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="notificationTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>For</th>
                                                    <th>Notification Type</th>
                                                    <th>Notification message</th>
                                                    <th>Notification Date</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data populated by DataTables -->
                                            </tbody>

                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- main-panel ends -->
            <!-- container-scroller -->
            <?php include('../functions/custom_alerts.php'); ?>
            <?php include('../partials/scripts.php') ?>
            <script src=" ../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/notifications-table.js"></script>


</body>

</html>