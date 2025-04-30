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
                        <h3 class="page-title"> Change Password </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
                                            <h4 class="card-title mb-4 float-center">Change Password</h4>
                                            <div class="d-flex justify-content-between">

                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <form id="passwordChangeForm">
                                                        <div class="form-group">
                                                            <label for="userPassword">New Password</label>
                                                            <input type="password" class="form-control" id="userPassword" name="userPassword" required>
                                                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="userConfirmPassword">Confirm Password</label>
                                                            <input type="password" class="form-control" id="userConfirmPassword" name="userConfirmPassword" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                                    </form>
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
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <?php include('../functions/custom_alerts.php'); ?>
        <script>
            const form = document.getElementById('passwordChangeForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                try {
                    const response = await fetch('../functions/update_password.php', {
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
        <?php include('../partials/scripts.php') ?>
        <!-- Ensure Bootstrap JS and Popper.js are included -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
        <script>
            // Initialize Bootstrap tabs
            document.addEventListener('DOMContentLoaded', function() {
                const triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs a'));
                triggerTabList.forEach(function(triggerEl) {
                    const tabTrigger = new bootstrap.Tab(triggerEl);
                    triggerEl.addEventListener('click', function(event) {
                        event.preventDefault();
                        tabTrigger.show();
                    });
                });
            });
        </script>
</body>

</html>