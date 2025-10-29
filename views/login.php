<?php
session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
require_once('../config/codeGen.php');
require '../vendor/autoload.php'; // Include PHPMailer autoload file



// Login Handler
if (isset($_POST['login'])) {
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($mysqli, $_POST['user_password']);

    // Check if user exists
    $result = $mysqli->query("SELECT * FROM users AS us INNER JOIN roles AS ro ON us.role_id = ro.role_id WHERE user_email='$user_email'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_object();

        if (password_verify($user_password, $row->user_password) && $row) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $row->user_id;
            $_SESSION['role_id'] = $row->role_id;

            // Redirect to token verification page
            if($_SESSION['authenticated']){
                header("Location:dashboard");
             
            }
           
        } else {
            $err = "Invalid email or password!";
           
        }
    
}
}


// Logout on token expiry or manual logout
if (isset($_GET['action']) && $_GET['action'] === "logout") {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../partials/head.php'); ?>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100">
                <div class="content-wrapper full-page-wrapper auth login-2 login-bg">
                    <div class="card col-6">
                        <div class="card-body px-5 py-5">
                            

                         
                                <h3 class="card-title text-start mb-3">Login</h3>
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label>User email *</label>
                                        <input type="text" class="form-control p_input" name="user_email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password *</label>
                                        <input type="password" name="user_password" class="form-control p_input" required>
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="remember"> Remember me
                                            </label>
                                        </div>
                                        <a href="reset_password.php" class="forgot-pass">Forgot password</a>
                                    </div>
                                    <div class="text-center d-grid gap-2">
                                        <button type="submit" name="login" class="btn btn-primary btn-block enter-btn">Login</button>
                                    </div>
                                    <p class="sign-up">Don't have an Account? <a href="register.php"> Register Here</a></p>
                                </form>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../partials/scripts.php'); ?>
</body>

</html>