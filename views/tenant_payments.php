<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login();
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
                        <h3 class="page-title">My Payments</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="tenant_dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payments</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tenantPaymentTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Invoice Number</th>
                                                    <th>Payment Method</th>
                                                    <th>Payment Amount</th>
                                                    <th>Payment Transaction Code</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tenantPaymentTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
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
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/tenant_payment-table.js"></script>

</body>

</html>
