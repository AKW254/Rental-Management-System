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
                                <li class="breadcrumb-item"><a href="landlord_dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rental Agreements</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                               
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="landlordrentalAgreementTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Room No</th>
                                                    <th>Property Name</th>
                                                    <th>Landlord Name</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="rentalAgreementTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/landlord_rental_agreement_modal.php'; ?>
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

            <!--Edit Rental Agreement Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('form[id^="editAgreementForm-"]').forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();

                            const formData = new FormData(this);
                            const rentalAgreementId = formData.get('agreement_id');

                            if (!rentalAgreementId) {
                                showToast('error', 'Missing agreement ID.');
                                return;
                            }


                            const res = await fetch('../functions/rental_agreements.php', {
                                method: 'POST',
                                body: formData
                            });

                            const result = await res.json();

                            if (result.success) {
                                const modalEl = document.getElementById('editAgreementModal-' + rentalAgreementId);
                                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                                if (modalInstance) {
                                    modalInstance.hide();
                                }
                                window.rentalAgreementTable?.ajax?.reload(null, false);
                                showToast('success', result.message);
                            } else {
                                showToast('error', result.message || 'An error occurred.');
                            }


                        });
                    });
                });
            </script>
            <!--Change Status of rental agreement -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document.querySelectorAll('form[id^="ChangeStatusrentalAgreementForm-"]').forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const rentalAgreementId = formData.get('agreement_id');
                           
                                const res = await fetch('../functions/rental_agreements.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await res.json();

                                if (result.success) {
                                    const modalEl = document.getElementById('ChangeStatusModal-' + rentalAgreementId);
                                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    }
                                    window.rentalAgreementTable?.ajax?.reload(null, false);
                                    showToast('success', result.message);
                                } else {
                                    showToast('error', result.message || 'An error occurred.');
                                }
                           
                        });
                    });
                });
            </script>

            </script>



            <!-- Script to get the role type from the selected role -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../public/assets/vendors/modal/modal-demo.js"></script>
            <?php include('../partials/scripts.php') ?>
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/landlord_rental_agreement_table.js"></script>


</body>

</html>