<?php
include('../config/config.php');
session_start();


    $msg = ""; // Initialize to prevent undefined variable error

    // Step 1: Request Reset
    if (isset($_POST['submit_request'])) {
        $email = $mysqli->real_escape_string($_POST['email']);

        // Check if user exists
        $result = $mysqli->query("SELECT user_email FROM users WHERE user_email='$email'");

        if ($result->num_rows > 0) {
            $token = rand(100000, 999999);
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_token'] = $token;
            $_SESSION['timer'] = time() + 300; // 5 minutes

            // Store token in DB
            $mysqli->query("UPDATE users SET user_password_reset_code='$token' WHERE user_email='$email'");

            $msg = "A reset token has been sent to your email.";
        } else {
            $msg = "User does not exist!";
        }
    }

    // Step 2: Verify Token
    if (isset($_POST['verify_token'])) {
        if (isset($_SESSION['reset_token']) && $_POST['token'] == $_SESSION['reset_token']) {
            $_SESSION['verified'] = true;
        } else {
            $msg = "Invalid token!";
        }
    }

    // Step 3: Update Password
    if (isset($_POST['update_password']) && isset($_SESSION['verified']) && $_SESSION['verified']) {
        $new_pass = $mysqli->real_escape_string($_POST['new_password']);
        $confirm_pass = $mysqli->real_escape_string($_POST['confirm_password']);

        if ($new_pass === $confirm_pass) {
            $hashed_pass = password_hash($new_pass, PASSWORD_BCRYPT);
            $email = $_SESSION['reset_email'];
            $mysqli->query("UPDATE users SET user_password='$hashed_pass', user_password_reset_code=NULL WHERE user_email='$email'");
            header("refresh:1; url=login");;
            //$msg = "Password successfully updated!";
            session_destroy();
        } else {
            $msg = "Passwords do not match!";
        }
    }

    // If user submits the Back form, destroy session without redirecting
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['timeout'])) {
        session_destroy();
        session_start(); // Restart a new session to avoid errors
        $msg = "Session cleared. You can start over.";
    }
?>

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
                            <h3 class="card-title text-start mb-3">Reset Password</h3>

                            <?php if (!isset($_SESSION['reset_email'])) { ?>
                                <!-- Step 1: Request Form -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" name="email" class="form-control p_input" required>
                                    </div>
                                    <p class="text-center text-danger"><?php echo $msg; ?></p>
                                    <div class="text-center d-grid gap-2">
                                        <button type="submit" name="submit_request" class="btn btn-primary btn-block enter-btn">Submit</button>
                                    </div>
                                </form>

                            <?php } elseif (!isset($_SESSION['verified'])) { ?>
                                <!-- Step 2: Token Verification -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Enter Token Here *</label>
                                        <input type="text" name="token" class="form-control p_input" required>
                                    </div>
                                    <!-- Countdown Timer -->
                                    <p id="timer" class="text-center text-primary font-weight-bold"></p>
                                    <p class="text-center text-danger"><?php echo $msg; ?></p>
                                    <div class="text-center d-grid gap-2">
                                        <button type="submit" name="verify_token" class="btn btn-primary btn-block enter-btn">Reset</button>
                                    </div>
                                </form>
                                
                                <form action="reset_password" method="post">
                                    <input type="hidden" name="logout" value="true">
                                    <div class="text-center d-grid gap-2 mt-3">
                                        <button type="submit" name="timeout" class="btn btn-secondary btn-block">Back</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <!-- Step 3: Update Password -->
                                <form method="POST">
                                    <div class="form-group">
                                        <label>New Password *</label>
                                        <input type="password" name="new_password" class="form-control p_input" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm New Password *</label>
                                        <input type="password" name="confirm_password" class="form-control p_input" required>
                                    </div>
                                    <div class="text-center d-grid gap-2 ">
                                        <button type="submit" name="update_password" class="btn btn-primary btn-block enter-btn">Update</button>
                                    </div>
                                </form>
                                <p class="text-center text-danger"><?php echo $msg; ?></p>
                            <?php } ?>




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
    <script>
        // Set total countdown time (5 minutes = 300 seconds)
        const totalTime = 300;

        // Get the stored expiration time or set a new one
        let expiryTime = sessionStorage.getItem("expiryTime");

        if (!expiryTime) {
            expiryTime = Date.now() + totalTime * 1000; // Store expiry time in milliseconds
            sessionStorage.setItem("expiryTime", expiryTime);
        }

        function updateTimer() {
            let remainingTime = Math.floor((expiryTime - Date.now()) / 1000);
            let timerElement = document.getElementById("timer");

            if (remainingTime > 0) {
                let minutes = Math.floor(remainingTime / 60);
                let seconds = remainingTime % 60;

                if (minutes > 0) {
                    timerElement.innerText = `Time Left: ${minutes}m ${seconds}s`;
                } else {
                    timerElement.innerText = `Time Left: ${seconds}s`; // Show only seconds when minutes = 0
                }

                setTimeout(updateTimer, 1000);
            } else {
                timerElement.innerText = "Time expired. Redirecting...";

                // Hide the button
                let button = document.querySelector("button[name='verify_token']");
                if (button) button.style.display = "none";

                // Remove expiryTime from sessionStorage
                sessionStorage.removeItem("expiryTime");

                // Redirect by submitting a hidden form to destroy the session
                document.getElementById("timeoutForm").submit();
            }
        }

        updateTimer(); // Start the countdown
    </script>



</body>

</html>