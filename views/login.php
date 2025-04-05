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

        if (password_verify($user_password, $row->user_password)) {
            $_SESSION['authenticated'] = true;
            $_SESSION['user_id'] = $row->user_id;
            $_SESSION['user_email'] = $row->user_email;
            $_SESSION['user_name'] = $row->user_name;
            $_SESSION['role_id'] = $row->role_id;
            $_SESSION['role_type'] = $row->role_type;
            // Generate a random authentication token
            // Ensure $auth_gen_token is defined in codeGen.php or replace with:
            // $auth_token = bin2hex(random_bytes(16));
            $auth_token = $auth_gen_token;
            $_SESSION['auth_token'] = $auth_token;
            $_SESSION['token_valid'] = false; // Token not validated yet
            $_SESSION['token_expiry'] = time() + (5 * 60); // 5 minutes expiry

           
            // Send token via email
            include('../mailers/user_auth_token.php');
            if (!$mail->send()) {
                $err = "Mailer Error: " . $mail->ErrorInfo;
              
            } else {
                $success="Token sent via email";
            }

            // Redirect to token verification page
            header("Location:login.php?step=verify");
            exit;
        } else {
            $err = "Invalid email or password!";
           
        }
    } else {
        $err = "Invalid email or password!";
       
    }
}

// Token Verification Handler
if (isset($_POST['verify_token'])) {
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header("Location: login.php");
        exit;
    }

    $user_token = trim($_POST['authToken']);

    if (isset($_SESSION['auth_token']) && hash_equals($_SESSION['auth_token'], $user_token)) {
        if (isset($_SESSION['token_expiry']) && time() > $_SESSION['token_expiry']) {
            $err = "Token has expired.";
            echo "<script>alert('" . $error . "');</script>";
            session_unset();
            session_destroy();
            header("Location: login.php?err=TokenExpired");
            exit;
        }
        $_SESSION['token_valid'] = true;
        unset($_SESSION['auth_token'], $_SESSION['token_expiry']);
        $success = "You have successfully logged in!";
      
        header("Location: dashboard.php");
        exit;
    } else {
        $err = "Invalid Authentication Token. Please try again.";
       
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
                            

                            <?php if (isset($_GET['step']) && $_GET['step'] === 'verify' && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) : ?>
                                <h3 class="card-title text-start mb-3">Verify Authentication Token</h3>
                                
                                <form method="POST" action="">
                                    <div class="form-group">
                                        <label>Enter Token *</label>
                                        <input type="text" class="form-control p_input" name="authToken" required>
                                    </div>
                                    <div class="text-center d-grid gap-2">
                                        <button type="submit" name="verify_token" class="btn btn-success btn-block enter-btn">Verify Token</button>
                                    </div>
                                </form>

                                <p id="timer" style="margin-top: 10px; color: red;"></p>

                                <script>
                                    // If token expiry is stored in the session, use that value; otherwise, default to 5 minutes.
                                    let defaultDuration = 5 * 60;
                                    <?php if (isset($_SESSION['token_expiry'])): ?>
                                        let expiryTime = <?= $_SESSION['token_expiry'] * 1000 ?>;
                                        let now = new Date().getTime();
                                        let remainingTime = Math.max(0, expiryTime - now);
                                        startTimer(remainingTime / 1000);
                                    <?php else: ?>
                                        startTimer(defaultDuration);
                                    <?php endif; ?>

                                    function startTimer(duration) {
                                        let timer = duration,
                                            minutes, seconds;
                                        const timerElement = document.getElementById('timer');
                                        const interval = setInterval(() => {
                                            minutes = parseInt(timer / 60, 10);
                                            seconds = parseInt(timer % 60, 10);
                                            minutes = minutes < 10 ? "0" + minutes : minutes;
                                            seconds = seconds < 10 ? "0" + seconds : seconds;
                                            timerElement.textContent = `Time remaining: ${minutes}:${seconds}`;
                                            if (--timer < 0) {
                                                clearInterval(interval);
                                                window.location.href = "login.php?action=logout";
                                            }
                                        }, 1000);
                                    }
                                </script>

                            <?php else : ?>
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
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../partials/scripts.php'); ?>
</body>

</html>