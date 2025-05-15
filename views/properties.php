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
                    <div class="page-header">
                        <h3 class="page-title"> Users </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Properties</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex align-items-right  flex-wrap">
                                    <div class="col-12 col-md-6 form-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyModal">Add Property</button>
                                        <!--Add User Modal -->
                                        <div class="modal fade" id="addPropertyModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addPropertyModalLabel">Add New Property</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="createPropertyForm" method="POST">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Property Name:</label>
                                                                    <input type="text" class="form-control" id="property_name" name="property_name" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Property location:</label>
                                                                    <input type="text" class="form-control" id="property_location" name="property_location" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Property Description:</label>
                                                                    <textarea class="form-control" id="property_description" name="property_description" required></textarea>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Select Property Manager:</label>
                                                                    <select name="property_manager_id" id="property_manager_id" class="form-control p_input">

                                                                        <?php
                                                                        $sql = "SELECT us.user_id, us.user_name FROM roles AS rs
                                                                         INNER JOIN users AS us ON us.role_id = rs.role_id 
                                                                         WHERE rs.role_id = '2'";
                                                                        $result = $mysqli->query($sql);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . $row['user_id'] . "'>" . $row['user_name'] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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
                                        <table id="propertyTable" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Property Name</th>
                                                    <th>Location</th>
                                                    <th>Description</th>
                                                    <th>Manager</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="propertyTableBody">
                                                <?php
                                                $count = 0;
                                                $sql = "SELECT p.property_id, p.property_name, p.property_location, p.property_description, u.user_name AS manager_name 
                                                        FROM properties AS p 
                                                        INNER JOIN users AS u ON p.property_manager_id = u.user_id";
                                                $stmt = $mysqli->query($sql);
                                                if ($stmt->num_rows > 0) {
                                                    while ($row = $stmt->fetch_assoc()) {
                                                        $count++;
                                                ?>
                                                        <tr data-property-id="<?= $row['property_id'] ?>">
                                                            <td><?php echo $count; ?></td>
                                                            <td><?php echo $row['property_name']; ?></td>
                                                            <td><?php echo $row['property_location']; ?></td>
                                                            <td><?php echo $row['property_description']; ?></td>
                                                            <td><?php echo $row['manager_name']; ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPropertyModal-<?php echo $row['property_id']; ?>">Edit</button>
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePropertyModal-<?php echo $row['property_id']; ?>">Delete</button>
                                                                <?php include('../helpers/modals/property_modal.php'); ?>
                                                            </td>
                                                        </tr>
                                                <?php }
                                                } ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- main-panel ends -->
                <!-- container-scroller -->
                <?php include('../functions/custom_alerts.php'); ?>


                <!--Add Property Script -->
                <!-- 2) Create‐Property handler -->
                <script>
                    document.getElementById('createPropertyForm').addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const form = this;
                        const formData = new FormData(form);

                        try {
                            const res = await fetch('../functions/create_property.php', {
                                method: 'POST',
                                body: formData
                            });
                            const result = await res.json();

                            if (!result.success) {
                                return showToast('error', result.error || 'Failed to create');
                            }

                            // Close modal
                            bootstrap.Modal.getInstance(
                                document.getElementById('addPropertyModal')
                            ).hide();

                            // 2) Reload the DataTable
                            if (window.propertyTable && window.propertyTable.ajax) {
                                window.propertyTable.ajax.reload(null, false);
                            }
                            showToast('success', result.message);
                        } catch (err) {
                            console.error(err);
                            showToast('error', 'Network error');
                        }
                    });
                </script>

                <!--Edit property Script -->
                <script>
                    //Edit user
                    const editForm = document.querySelectorAll('form[id^="editPropertyForm-"]');
                    editForm.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const propertyId = formData.get('Property_id');
                            const propertyName = formData.get('property_name');
                            const propertyDescription = formData.get('property_description');
                            const propertyManagerName = formData.get('property_manager_name');
                            try {
                                const response = await fetch('../functions/edit_user.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                if (result.success) {
                                    // Update the property details in the table
                                    const row = document.querySelector(`tr[data-property-id="${propertyId}"]`);
                                    if (row) {
                                        row.querySelector('td:nth-child(2)').innerText = propertyName;
                                        row.querySelector('td:nth-child(3)').innerText = propertyDescription;
                                        row.querySelector('td:nth-child(4)').innerText = propertyManagerId;
                                    }
                                    // Close the modal
                                    const modalEl = this.closest('.modal');
                                    bootstrap.Modal.getInstance(modalEl).hide();
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
                </script>
                <!--Delete Property Script -->

                <script>
                    const deletePropertyForms = document.querySelectorAll('form[id^="deletePropertyForm-"]');
                    deletePropertyForms.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const propertyId = formData.get('property_id');

                            try {
                                const response = await fetch('../functions/delete_property.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                if (result.success) {
                                    // Remove the user row from the table
                                    const row = document.querySelector(`tr[data-property-id="${propertyId}"]`);
                                    if (row) {
                                        row.remove();
                                    }
                                    // Close the modal
                                    const modalEl = this.closest('.modal');
                                    bootstrap.Modal.getInstance(modalEl).hide();
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
                </script>
                <!-- Script to get the role type from the selected role -->
                <script src="../public/assets/vendors/js/twoinone.js"> </script>
                <script src="../public/assets/vendors/modal/modal-demo.js"></script>
                <?php include('../partials/scripts.php') ?>
                <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/property-table.js"></script>



</body>



</html>