<!DOCTYPE html>
<html lang="en">
<?php include('../partials/head.php') ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100">
                <div class="content-wrapper full-page-wrapper auth login-2 login-bg">
                    <div class="card col-6">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-start mb-3">Login</h3>
                            <form>
                                <div class="form-group">
                                    <label>Username or email *</label>
                                    <input type="text" class="form-control p_input">
                                </div>
                                <div class="form-group">
                                    <label>Password *</label>
                                    <input type="text" class="form-control p_input">
                                </div>
                                <div class="form-group d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input"> Remember me </label>
                                    </div>
                                    <a href="#" class="forgot-pass">Forgot password</a>
                                </div>
                                <div class="text-center d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                                </div>
                                <div class="d-flex">
                                    <button class="btn btn-facebook col me-2">
                                        <i class="mdi mdi-facebook"></i> Facebook </button>
                                    <button class="btn btn-google col">
                                        <i class="mdi mdi-google-plus"></i> Google plus </button>
                                </div>
                                <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <?php include('../partials/scripts.php') ?>
</body>

</html>