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

<body>
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
                    <?php require_once('../helpers/analysis/admin.php') ?>
                    <div class="row g-4">
                        <!-- Total Properties -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Total Properties</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_properties ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Rooms -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Total Rooms</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_rooms ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Active Agreements -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Active Agreements</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_agreements ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Maintenance -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Pending Maintenance</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_maintenance ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Tenants -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Registered Tenants</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_tenants ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Landlords -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Total Landlords</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_landlords ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row px-4 py-4">

                        <!-- Pie chart of Users roles -->

                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="card-body">
                                <h4 class="card-title">Users Roles</h4>
                                <div class="doughnutjs-wrapper d-flex justify-content-center">
                                    <canvas id="doughnutChart" style="height: 240px; display: block; box-sizing: border-box; width: 240px;" width="240" height="240"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Area chart annual collected -->
                        <div class="col-sm-12 col-md-6 col-xl-8">
                            <div class="card-body">
                                <h4 class="card-title">Annual Collected Rent</h4>
                                <div class="area-chartjs-wrapper">
                                    <canvas id="areaChart" style="height: 250px; display: block; box-sizing: border-box; width: 480px;" width="480" height="420"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Line chart for tenant and landlord registration -->
                        <div class="col-sm-12 col-md-6 col-xl-8">
                            <div class="card-body">
                                <h4 class="card-title">Tenant and Landlord Registration</h4>
                                <div class="line-chartjs-wrapper">
                                    <canvas id="lineChart" style="height: 240px; display: block; box-sizing: border-box; width: 480px;" width="480" height="240"></canvas>
                                </div>
                            </div>
                            <!--Line chart for tenant and landlord registration-->
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->
                    <?php include('../partials/footer.php') ?>
                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- visualization chart -->
        <!-- Doughnut Chart -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <?php include('../helpers/visualization/admin_charts.php'); ?>
        <?php include('../partials/scripts.php') ?>


</body>



</html>