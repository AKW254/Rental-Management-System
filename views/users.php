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
                                <li class="breadcrumb-item active" aria-current="page">Users</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="d-flex align-items-right  flex-wrap">
                                    <div class="col-12 col-md-6 form-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                                        <!--Add User Modal -->
                                        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="addUserForm" method="POST">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Full Name:</label>
                                                                    <input type="text" class="form-control" id="UserName" name="user_name" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Email:</label>
                                                                    <input type="email" class="form-control" id="UserEmail" name="user_email" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="recipient-name" class="col-form-label">Phone No:</label>
                                                                    <input type="text" class="form-control" id="UserPhone" name="user_phone" required>
                                                                </div>
                                                                <div class="col-sm-12 col-md-6 col-xl-6">
                                                                    <label for="message-text" class="col-form-label">Select User Role:</label>
                                                                    <select name="role_id" class="form-control p_input">
                                                                        <option value="">Select Role</option>
                                                                        <?php
                                                                        $sql = "SELECT role_id, role_type FROM roles";
                                                                        $result = $mysqli->query($sql);
                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
                                                                                echo "<option value='" . $row['role_id'] . "' data-role-type='" . $row['role_type'] . "'>" . $row['role_type'] . "</option>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <input type="hidden" name="role_type" id="role_type">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>

                                                        </form>
                                                        <!-- Script to get the role type from the selected role -->
                                                        <script src="../public/assets/vendors/js/twoinone.js"> </script>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th> #</th>
                                                    <th>User Name</th>
                                                    <th>User Email</th>
                                                    <th>User Phone</th>
                                                    <th>Role Type</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = '0';
                                                $sql = "SELECT us.user_id,us.user_name,us.user_email,us.user_phone,rs.role_id,rs.role_type FROM users AS us 
                                                        INNER JOIN roles AS rs ON us.role_id = rs.role_id ";
                                                $stmt = $mysqli->query($sql);
                                                if ($stmt->num_rows > 0) {
                                                    while ($row = $stmt->fetch_assoc()) {
                                                        $count = $count + 1;

                                                ?>
                                                        <tr data-user-id="<?= $row['user_id'] ?>">
                                                            <td><?php echo $count; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($_SESSION['user_id'] == $row['user_id']) {
                                                                    echo "You";
                                                                } else {
                                                                    echo $row['user_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row['user_email'] ?></td>
                                                            <td><?php echo $row['user_phone'] ?></td>
                                                            <td class="role-cell"><?php echo $row['role_type'] ?></td>

                                                            <td>
                                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#changeRoleUserModal-<?php echo $row['user_id'] ?>">Change Role</button>
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal-<?php echo $row['user_id'] ?>">Edit</button>
                                                                <?php if ($_SESSION['user_id'] != $row['user_id']) { ?>
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal-<?php echo $row['user_id'] ?>">Delete</button>
                                                                <?php } ?>
                                                                <?php include('../helpers/modals/user_modal.php'); ?>
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
                <!--Add User Script -->
                <script>
                    //create user
                    const form = document.getElementById('addUserForm');
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        try {
                            const response = await fetch('../functions/create_user.php', {
                                method: 'POST',
                                body: formData
                            });

                            const result = await response.json();

                            if (result.success) {
                                showToast('success', result.message);
                            } else {
                                showToast('error', result.error || 'An error occurred.');
                            }
                        } catch (error) {
                            console.error('Fetch error:', error);
                            showToast('error', 'A network error occurred.');
                        }
                    });
                </script>
                <!--Change User Role Script -->
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        // Attach to every Change Role form
                        document.querySelectorAll("form[id^='changeRoleUserForm-']").forEach(form => {
                            form.addEventListener('submit', async function(e) {
                                e.preventDefault();
                                const formData = new FormData(this);
                                const userId = formData.get('user_id');
                                const select = this.querySelector('select[name="role_id"]');
                                const newRole = select.options[select.selectedIndex].text;

                                try {
                                    const res = await fetch('../functions/change_role.php', {
                                        method: 'POST',
                                        body: formData
                                    });
                                    const json = await res.json();

                                    if (json.success) {
                                        // 1) Update the role cell in the corresponding row
                                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                                        if (row) {
                                            row.querySelector('.role-cell').innerText = newRole;
                                        }

                                        // 2) Close the Bootstrap modal
                                        const modalEl = this.closest('.modal');
                                        bootstrap.Modal.getInstance(modalEl).hide();

                                        // 3) Show a toast or alert
                                        showToast('success', json.message);
                                    } else {
                                        showToast('error', json.error || 'Failed to update role');
                                    }
                                } catch (err) {
                                    console.error(err);
                                    showToast('error', 'Network error');
                                }
                            });
                        });
                    });
                </script>
                <!--Edit User Script -->
                <script>
                    //Edit user
                    const editForm = document.querySelectorAll('form[id^="editUserForm-"]');
                    editForm.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const userId = formData.get('user_id');
                            const userName = formData.get('user_name');
                            const userEmail = formData.get('user_email');
                            const userPhone = formData.get('user_phone');
                            try {
                                const response = await fetch('../functions/edit_user.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                if (result.success) {
                                    // Update the user details in the table
                                    const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                                    if (row) {
                                        row.querySelector('td:nth-child(2)').innerText = userName;
                                        row.querySelector('td:nth-child(3)').innerText = userEmail;
                                        row.querySelector('td:nth-child(4)').innerText = userPhone;
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
                <!--Delete User Script -->
                <script>
                    const deleteForms = document.querySelectorAll('form[id^="deleteUserForm-"]');
                    deleteForms.forEach(form => {
                        form.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            const userId = formData.get('user_id');

                            try {
                                const response = await fetch('../functions/delete_user.php', {
                                    method: 'POST',
                                    body: formData
                                });

                                const result = await response.json();

                                if (result.success) {
                                    // Check if the deleted user is the current user
                                    if (userId === '<?php echo $_SESSION['user_id']; ?>') {
                                        // Redirect to login page
                                        window.location.href = 'logout.php';
                                    } else {
                                        // Remove the user row from the table
                                        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
                                        if (row) {
                                            row.remove();
                                        }
                                        // Close the modal
                                        const modalEl = this.closest('.modal');
                                        bootstrap.Modal.getInstance(modalEl).hide();
                                        showToast('success', result.message);
                                    }
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

                <script src="../public/assets/vendors/modal/modal-demo.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/data-table.js"></script>
                
                <?php include('../partials/scripts.php') ?>


</body>



</html>