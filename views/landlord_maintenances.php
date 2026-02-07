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
                        <h3 class="page-title">Landlord Maintenances </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="landlorddashboard">Landlord Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Maintenances</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="landlordrequestTable" class="table">
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
                                            <tbody id="requestTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/landlord_request_modal.php'; ?>
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




            <!--Edit Maintance request Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document
                        .querySelectorAll('form[id^="editrequestForm-"]')
                        .forEach(form => {
                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                const maintenanceRequestId = formData.get('maintenance_request_id');
                                try {
                                    const res = await fetch('../functions/maintenance.php', {
                                        method: 'POST',
                                        body: formData
                                    });
                                    const result = await res.json();

                                    if (result.success) {
                                        // Safely close the modal
                                        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editRequestModal-' + maintenanceRequestId));
                                        modal.hide();

                                        // Refresh DataTable
                                        window.requestTable?.ajax?.reload(null, false);
                                        showToast('success', result.message);
                                    } else {
                                        showToast('error', result.error);
                                    }
                                } catch (err) {
                                    console.error(err);
                                    showToast('error', 'Network error');
                                }
                            });
                        });
                });
            </script>


            <!--Delete maintence request Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const deleteRequestForms = document.querySelectorAll('form[id^="deleteRequestForm-"]');
                    deleteRequestForms.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const maintenanceRequestId = formData.get('maintenance_request_id');
                            try {
                                const response = await fetch('../functions/maintenance.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await response.json();

                                if (result.success) {
                                    // Close modal
                                    bootstrap.Modal.getInstance(
                                        document.getElementById('deleteRequestModal-' + maintenanceRequestId)
                                    ).hide();

                                    // Reload the DataTable
                                    if (window.requestTable && window.requestTable.ajax) {
                                        window.requestTable.ajax.reload(null, false);
                                    }
                                    showToast('success', result.message);
                                } else {
                                    showToast('error', result.error || 'An error occurred.');
                                }
                            } catch (error) {
                                console.error('Fetch error:', error);
                                showToast('error', 'A network error occurred.');
                            }
                        });
                    });
                });
            </script>
            <!-- Removed: Script to get the role type from the selected role -->

            <?php include('../partials/scripts.php') ?>
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/landlordrequest.js"></script>


</body>

</html>