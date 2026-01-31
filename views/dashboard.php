<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login()


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
                                <div class="doughnutjs-wrapper">
                                    <canvas id="doughnutChart" width="250" height="350"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- Area chart annual collected -->
                        <div class="col-sm-12 col-md-6 col-xl-8">
                            <div class="card-body">
                                <h4 class="card-title">Annual Collected Rent</h4>
                                    <canvas id="areaChart" width="250" height="100"></canvas>
                            </div>
                        </div>
                        <!-- Line chart for tenant and landlord registration -->
                        <div class="col-sm-12 col-md-6 col-xl-8">
                            <div class="card-body">
                                <h4 class="card-title">Tenant and Landlord Registration</h4>
                                <div class="height: auto; width: 50%; display: block; box-sizing: border-box;">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!--Visitattion chart -->
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div class="card-body">
                                <h4 class="card-title">Visits</h4>
                                <div class="">
                                    <div id="map" style="height:500px;"></div>
                                </div>
                            </div>
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <?php include('../helpers/visualization/admin_charts.php'); ?>
        <?php include('../partials/scripts.php') ?>
        <!-- Leaflet Map Visualization -->
        <script>
            // Initialize the map
            var map = L.map('map').setView([20, 0], 2); // Centered at [20, 0] with zoom level 2

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Fetch location data from the server
            fetch('../functions/fetch_locations.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(location => {
                        var lat = location.latitude;
                        var lon = location.longitude;

                        // Add a marker for each location
                        L.marker([lat, lon]).addTo(map);
                    });
                })
                .catch(error => console.error('Error fetching location data:', error));
                </script>


</body>



</html>