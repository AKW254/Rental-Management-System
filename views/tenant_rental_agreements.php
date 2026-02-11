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
                    <div class="page-header">
                        <h3 class="page-title"> Rental Agreements </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="tenant_dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rental Agreements</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                               

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tenantrentalAgreementTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Room No</th>
                                                    <th>Property Name</th>
                                                    <th>Landlord Name</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Status</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody id="rentalAgreementTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/tenant_rental_agreement_modal.php'; ?>
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

         

          



            <!-- Script to get the role type from the selected role -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../public/assets/vendors/modal/modal-demo.js"></script>
            <?php include('../partials/scripts.php') ?>
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/tenant_rental_agreement_table.js"></script>


</body>

</html>