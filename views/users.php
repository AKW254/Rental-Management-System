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
                                                    <th>Order #</th>
                                                    <th>Purchased On</th>
                                                    <th>Customer</th>
                                                    <th>Ship to</th>
                                                    <th>Base Price</th>
                                                    <th>Purchased Price</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2012/08/03</td>
                                                    <td>Edinburgh</td>
                                                    <td>New York</td>
                                                    <td>$1500</td>
                                                    <td>$3200</td>
                                                    <td>
                                                        <label class="badge badge-info">On hold</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>2015/04/01</td>
                                                    <td>Doe</td>
                                                    <td>Brazil</td>
                                                    <td>$4500</td>
                                                    <td>$7500</td>
                                                    <td>
                                                        <label class="badge badge-danger">Pending</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>2010/11/21</td>
                                                    <td>Sam</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-success">Closed</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>2016/01/12</td>
                                                    <td>Sam</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-success">Closed</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>2017/12/28</td>
                                                    <td>Sam</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-success">Closed</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>2000/10/30</td>
                                                    <td>Sam</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-info">On-hold</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>2011/03/11</td>
                                                    <td>Cris</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-success">Closed</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>2015/06/25</td>
                                                    <td>Tim</td>
                                                    <td>Italy</td>
                                                    <td>$6300</td>
                                                    <td>$2100</td>
                                                    <td>
                                                        <label class="badge badge-info">On-hold</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>2016/11/12</td>
                                                    <td>John</td>
                                                    <td>Tokyo</td>
                                                    <td>$2100</td>
                                                    <td>$6300</td>
                                                    <td>
                                                        <label class="badge badge-success">Closed</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>2003/12/26</td>
                                                    <td>Tom</td>
                                                    <td>Germany</td>
                                                    <td>$1100</td>
                                                    <td>$2300</td>
                                                    <td>
                                                        <label class="badge badge-danger">Pending</label>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary">View</button>
                                                    </td>
                                                </tr>
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

                <script src="../public/assets/vendors/modal/modal-demo.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs4/1.11.2/dataTables.bootstrap4.js" integrity="sha512-SOUJxnrrYg/FO1OY7UDw1h0nUw2LtMar68dNgVwekH2Rm+BdVNO5OTHOfDCGtTGcnZbXBHvWkIoh2WTyFIXVNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/query.dataTables.js"></script>
                <script src="../public/assets/vendors/datatables.net-bs4/data-table.js"></script>
                <?php include('../partials/scripts.php') ?>


</body>



</html>