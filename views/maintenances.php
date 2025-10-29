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
                    <div class="page-header">
                        <h3 class="page-title"> Maintenances </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Maintenances</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex justify-content-end flex-wrap">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestMaintenanceModal">Request Maintenance</button>
                                </div>
                                <div class="col-12 col-md-6 form-group">
                                    <!--Add Request Modal -->
                                    <div class="modal fade" id="requestMaintenanceModal" tabindex="-1" role="dialog" aria-labelledby="requestMaintenanceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Request Maintenance</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="requestMaintenanceForm" method="POST" enctype="multipart/form-data">
                                                        <input type="hidden" name="action" value="create">

                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-6 col-xl-6">
                                                                <label for="message-text" class="col-form-label">Select Rental Room:</label>
                                                                <select name="room_id" id="room_id" class="form-control p_input">

                                                                    <?php
                                                                    $sql = "SELECT rs.room_title, rl.room_id FROM rooms AS rs INNER JOIN rental_agreements AS rl ON rs.room_id = rl.room_id WHERE rl.tenant_id = ?";
                                                                    $stmt = $mysqli->prepare($sql);
                                                                    $stmt->bind_param("s", $_SESSION['user_id']);
                                                                    $stmt->execute();
                                                                    $result = $stmt->get_result();
                                                                    if ($result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            echo "<option value='" . $row['room_id'] . "'>" . $row['room_title'] . "</option>";
                                                                        }
                                                                    }
                                                                    $stmt->close();

                                                                    ?>
                                                                </select>

                                                            </div>

                                                            <div class="col-sm-12 col-md-6 col-xl-6">
                                                                <label for="recipient-name" class="col-form-label">Maintenance Description:</label>
                                                                <textarea class="form-control" id="maintenance_request_description" name="maintenance_request_description" required></textarea>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="requestMaintenanceSubmit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="table-responsive">
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
                                            <tbody id="requestTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/request_modal.php'; ?>
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

            <!--Create Maintainance request Script -->
            <script>
                document.getElementById("requestMaintenanceForm").addEventListener("submit", async function(e) {
                    e.preventDefault();
                    const form = this;
                    const formData = new FormData(form);
                    try {
                        const res = await fetch('../functions/maintenance.php', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await res.json();

                        if (result.success) {
                            // Safely close the modal
                            const modalEl = document.getElementById('requestMaintenanceModal');
                            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                            if (window.requestTable?.ajax) {
                                window.requestTable.ajax.reload(null, false);
                            }
                            // Show success message
                            showToast('success', result.message);
                        } else {
                            showToast('error', result.error);
                            console.error('Error details:', result);
                        }
                    } catch (err) {
                        console.error('Error occurred while submitting the form:', err);
                        showToast('error', 'A network error occurred. Please try again later.');
                    }
                });
            </script>

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
            <script src="../public/assets/vendors/datatables.net-bs4/request-table.js"></script>


</body>

</html>