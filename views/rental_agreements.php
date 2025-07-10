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
                        <h3 class="page-title"> Rental Agreements </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rental Agreements</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex align-items-right  flex-wrap">
                                    <div class="col-12 col-md-6 form-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rentalagreementModal">Create Rental Agreement</button>
                                        <!--Add Rental Room Modal -->
                                        <div class="modal fade" id="rentalagreementModal" tabindex="-1" role="dialog" aria-labelledby="rentalagreementModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Rental Agreement</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="createRentalAgreementForm" method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="action" value="create">

                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12 col-xl-12">
                                                                    <label for="message-text" class="col-form-label">Select Room:</label>
                                                                    <select name="room_id" id="room_id" class="form-control p_input">

                                                                        <?php
                                                                        $sql = "SELECT room_title,room_id FROM rooms WHERE room_availability='Available'; ";
                                                                        $result = $mysqli->query($sql);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . $row['room_id'] . "'>" . $row['room_title'] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="add_rental_agreement" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="rentalAgreementTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Room No</th>
                                                    <th>Property Name</th>
                                                    <th>Tenant Name</th>
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
                                        <?php include '../helpers/modals/rental_agreement_modal.php'; ?>
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

            <!--Create Rental Agreement Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const createRentalAgreementForm = document.getElementById('createRentalAgreementForm');
                    if (createRentalAgreementForm) {
                        createRentalAgreementForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            try {
                                const res = await fetch('../functions/rental_agreements.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await res.json();

                                if (result.success) {
                                    const modalEl = document.getElementById('rentalagreementModal');
                                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    }
                                    if (window.rentalAgreementTable?.ajax) {
                                        window.rentalAgreementTable.ajax.reload(null, false);
                                    }
                                    showToast('success', result.message);
                                } else {
                                    showToast('error', result.message || 'An error occurred.');
                                }

                            } catch (err) {
                                console.error('Error occurred while submitting the form:', err);
                                showToast('error', 'A network error occurred. Please try again later.');
                            }
                        });
                    }
                });
            </script>

            </script>
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
            <script src="../public/assets/vendors/datatables.net-bs4/rental_agreement_table.js"></script>


</body>

</html>