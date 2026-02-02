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
                    <?php require_once('../helpers/analysis/landlord.php') ?>
                    <div class="row g-4">
                        <!-- Total Properties -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Number of Properties</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $no_of_properties ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Rooms -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Number of Rooms</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $no_of_rooms ?></h3>
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
                        <!-- Revenue  -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Revenue collected</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $revenue_collected_per_landlord 
                                                                ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contain-fluid mx-2 my-2 px-2 py-2">
                        <div class="col-12">
                            <h3>Tenant Risk analysis</h3>
                            <table id="requestTable" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room No</th>
                                        <th>Requested By</th>
                                        <th>Request To</th>
                                        <th>Maintenance Request Description</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables will populate via Datatable initilazation -->
                                </tbody>
                            </table>

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