<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../partials/head.php'); ?>

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
                        <h3 class="page-title"> Profile </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="border-bottom text-center pb-4">
                                                <img src="../public/images/dummy profile.jpg" alt="profile" class="img-lg rounded-circle mb-3">

                                            </div>
                                            <div class="py-4">

                                                <p class="clearfix">
                                                    <span class="float-left"> Phone </span>
                                                    <span class="float-right text-muted"> <?php echo $_SESSION['user_phone']; ?> </span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left"> Mail </span>
                                                    <span class="float-right text-muted"> <?php echo $_SESSION['user_email']; ?> </span>
                                                </p>
                                                <p class="clearfix">
                                                    <span class="float-left"> Since </span>
                                                    <span class="float-right text-muted">
                                                        <?php echo date('d M Y', strtotime($_SESSION['user_created_at'])); ?>
                                                    </span>
                                                </p>

                                                <p class="clearfix">
                                                    <span class="float-left"> Status </span>
                                                    <span class="float-right text-muted"> Active </span>
                                                </p>
                                            </div>

                                        </div>
                                        <div class="col-lg-8">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-column">
                                                    <h3 class="font-weight-bold dynamictext" data-type="user_name"> <?php echo $_SESSION['user_name']; ?> </h3>
                                                    <h6 class="font-weight-normal mb-0"> <?php echo $_SESSION['role_type']; ?> </h6>
                                                </div>
                                            </div>


                                            <div class="mt-4 py-2 border-top border-bottom">
                                                <?php
                                                // Check user role and display appropriate tabs
                                                if ($_SESSION['role_id'] === '1') {
                                                ?>
                                                    <ul class="nav profile-navbar" id="profileTabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#rentHistory" data-bs-toggle="tab">
                                                                Rent History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#propertyHistory" data-bs-toggle="tab">
                                                                Property History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#rentalAgreements" data-bs-toggle="tab">
                                                                Rental Agreements </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#accountupdate" data-bs-toggle="tab">
                                                                Account setting </a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } elseif ($_SESSION['role_id'] === '2') {
                                                ?>
                                                    <ul class="nav profile-navbar" id="profileTabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#roomRentHistory" data-bs-toggle="tab">
                                                                Room Rent History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#rentHistory" data-bs-toggle="tab">
                                                                Rent History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#rentalAgreements" data-bs-toggle="tab">
                                                                Rental Agreements </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#accountupdate" data-bs-toggle="tab">
                                                                Account setting </a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                } elseif ($_SESSION['role_id'] === '3') {
                                                ?>
                                                    <ul class="nav profile-navbar" id="profileTabs">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#rentHistory" data-bs-toggle="tab">
                                                                Rent History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#paymentHistory" data-bs-toggle="tab">
                                                                Payment History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#maintenanceRequests" data-bs-toggle="tab">
                                                                Maintenance Request History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#accountupdate" data-bs-toggle="tab">
                                                                Account setting </a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <div class="tab-content mt-4">
                                                <div class="tab-pane fade show active" id="rentHistory">
                                                    <h4>Rent History</h4>
                                                    <p>Display rent history details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="propertyHistory">
                                                    <h4>Property History</h4>
                                                    <p>Display property history details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="rentalAgreements">
                                                    <h4>Rental Agreements</h4>
                                                    <p>Display rental agreements details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="roomRentHistory">
                                                    <h4>Room Rent History</h4>
                                                    <p>Display room rent history details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="paymentHistory">
                                                    <h4>Payment History</h4>
                                                    <p>Display payment history details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="maintenanceRequests">
                                                    <h4>Maintenance Request History</h4>
                                                    <p>Display maintenance request history details here...</p>
                                                </div>
                                                <div class="tab-pane fade" id="accountupdate">
                                                    <h4>Account Setting</h4>
                                                    <form id="accountUpdateForm">
                                                        <div class="form-group">
                                                            <label for="userName">Name</label>
                                                            <input type="text" class="form-control" id="userName" name="user_name" value="<?php echo $_SESSION['user_name']; ?>" required>
                                                            <input type="hidden" class="form-control" id="userId" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" required hidden>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="userEmail">Email</label>
                                                            <input type="email" class="form-control" id="userEmail" name="user_email" value="<?php echo $_SESSION['user_email']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="userPhone">Phone</label>
                                                            <input type="text" class="form-control" id="userPhone" name="user_phone" value="<?php echo $_SESSION['user_phone']; ?>" required>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary mt-3">Update</button>
                                                    </form>
                                                    <?php include('../functions/custom_alerts.php'); ?>
                                                    <script>
                                                        const form = document.getElementById('accountUpdateForm');
                                                        form.addEventListener('submit', async function(e) {
                                                            e.preventDefault();
                                                            const formData = new FormData(this);

                                                            try {
                                                                const response = await fetch('../functions/update_account.php', {
                                                                    method: 'POST',
                                                                    body: formData
                                                                });

                                                                const result = await response.json();

                                                                if (result.success) {
                                                                    showToast('success', result.message);

                                                                    // ✅ Update UI elements
                                                                    document.querySelectorAll('.float-right.text-muted').forEach((element) => {
                                                                        if (element.previousElementSibling?.textContent?.trim() === "Phone") {
                                                                            element.textContent = result.updated_data.user_phone;
                                                                        } else if (element.previousElementSibling?.textContent?.trim() === "Mail") {
                                                                            element.textContent = result.updated_data.user_email;
                                                                        }
                                                                    });

                                                                    document.querySelectorAll('.dynamictext').forEach((element) => {
                                                                        if (element.dataset.type === "user_name") {
                                                                            element.textContent = result.updated_data.user_name;
                                                                        }
                                                                    });

                                                                    // ✅ Update input fields
                                                                    document.getElementById('userName').value = result.updated_data.user_name;
                                                                    document.getElementById('userEmail').value = result.updated_data.user_email;
                                                                    document.getElementById('userPhone').value = result.updated_data.user_phone;

                                                                } else {
                                                                    showToast('error', result.error || 'An error occurred.');
                                                                }
                                                            } catch (error) {
                                                                console.error('Fetch error:', error);
                                                                showToast('error', 'A network error occurred.');
                                                            }
                                                        });
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <?php include('../partials/footer.php') ?>
                <!-- partial -->

                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <?php include('../partials/scripts.php') ?>
</body>

</html>