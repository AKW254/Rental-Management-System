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
                        <h3 class="page-title"> Rooms </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rooms</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex align-items-right  flex-wrap">
                                    <div class="col-12 col-md-6 form-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal">Add Room</button>
                                        <!--Add Room Modal -->
                                        <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add New Room</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="createRoomForm" method="POST" enctype="multipart/form-data">
                                                            <input type="hidden" name="action" value="create">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Room No:</label>
                                                                    <input type="text" class="form-control" id="room_title" name="room_title" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Room Image:</label>
                                                                    <input type="file" class="form-control" id="room_image" name="room_image" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Room Rent:</label>
                                                                    <input class="form-control" id="room_rent_amount" name="room_rent_amount" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Select Property:</label>
                                                                    <select name="property_id" id="property_id" class="form-control p_input">

                                                                        <?php
                                                                        $sql = "SELECT property_name,property_id FROM properties";
                                                                        $result = $mysqli->query($sql);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . $row['property_id'] . "'>" . $row['property_name'] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="add_room" class="btn btn-primary">Save changes</button>
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
                                        <table id="roomTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Room No</th>
                                                    <th>Property Name</th>
                                                    <th>Room Rent</th>
                                                    <th>Room Availability</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="roomsTableBody">
                                                <!-- DataTables will populate via Datatable initilazation -->
                                            </tbody>
                                        </table>
                                        <?php include '../helpers/modals/room_modal.php'; ?>
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

            <!--Create Room Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const createRoomForm = document.getElementById('createRoomForm');
                    if (createRoomForm) {
                        createRoomForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            try {
                                const res = await fetch('../functions/rooms.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await res.json();

                                if (result.success) {
                                    // Safely close the modal
                                    const modalEl = document.getElementById('addRoomModal');
                                    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                                    if (modalInstance) {
                                        modalInstance.hide();
                                    }
                                    if (window.roomTable?.ajax) {
                                        window.roomTable.ajax.reload(null, false);
                                    }
                                    // Show success message
                                    showToast('success', result.message);
                                } else {
                                    showToast('error', result.error);
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
            <!--Edit Room Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    document
                        .querySelectorAll('form[id^="editroomForm-"]')
                        .forEach(form => {
                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                const roomId = formData.get('room_id');
                                try {
                                    const res = await fetch('../functions/rooms.php', {
                                        method: 'POST',
                                        body: formData
                                    });
                                    const result = await res.json();

                                    if (result.success) {
                                        // Safely close the modal
                                        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('editRoomModal-' + roomId));
                                        modal.hide();

                                        // Refresh DataTable
                                        window.roomTable?.ajax?.reload(null, false);
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


            <!--Delete Property Script -->
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const deleteRoomForms = document.querySelectorAll('form[id^="deleteRoomForm-"]');
                    deleteRoomForms.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const roomId = formData.get('room_id');

                            try {
                                const response = await fetch('../functions/rooms.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                if (result.success) {
                                    // Close modal
                                    bootstrap.Modal.getInstance(
                                        document.getElementById('deleteRoomModal-' + roomId)
                                    ).hide();

                                    // 2) Reload the DataTable
                                    if (window.roomTable && window.roomTable.ajax) {
                                        window.roomTable.ajax.reload(null, false);
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
            <!-- Script to get the role type from the selected role -->
            <script src="../public/assets/vendors/js/twoinone.js"> </script>
            <script src="../public/assets/vendors/modal/modal-demo.js"></script>
            <?php include('../partials/scripts.php') ?>
            <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
            <script src="../public/assets/vendors/datatables.net-bs4/room-table.js"></script>



</body>



</html>