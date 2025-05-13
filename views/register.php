<?php
//connection from DB
include("../config/config.php");
require '../vendor/autoload.php'; // Include PHPMailer autoload file
require_once('../functions/password_standard.php'); // Include password standard function

    //registration
    if (isset($_POST['registration'])) {
        // Sanitize and assign inputs
        $user_name     = $mysqli->real_escape_string(trim($_POST['user_name']));
        $user_email    = $mysqli->real_escape_string(trim($_POST['user_email']));
        $user_phone    = $mysqli->real_escape_string(trim($_POST['user_phone']));
        $user_password = $_POST['user_password'];
        $confirm_password = $_POST['confirm_password'];
        $role_id       = $mysqli->real_escape_string($_POST['role_id']);
        $user_role     = $mysqli->real_escape_string($_POST['role_type']);

        // Validate password match
        if ($user_password !== $confirm_password) {
            $err = "Passwords do not match!";
        }
        // Validate password strength
        elseif (($standard_check = password_standard($user_password)) !== true) {
            $err = $standard_check;
        } else {
            // Check if email is already registered
            $stmt = $mysqli->prepare("SELECT 1 FROM users WHERE user_email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $err = "Email already registered!";
            } else {
                // Hash password and insert into database
                $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare("INSERT INTO users (user_name, user_email, user_password, role_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $user_name, $user_email, $hashed_password, $role_id);

                if ($stmt->execute()) {
                    include('../mailers/user_onboarding.php');

                    try {
                        if ($mail->send()) {
                            $success = "Registration successful! Please check your email.";
                            header("Location: login");
                            exit;
                        } else {
                            $info = "Registered, but email not sent: {$mail->ErrorInfo}";
                        }
                    } catch (Exception $e) {
                        $err = "Registered, but email failed: {$e->getMessage()}";
                    }
                } else {
                    $err = "Registration failed. Please try again.";
                }
            }

            $stmt->close();
        }
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
                            <h3 class="card-title text-start mb-3">Registration</h3>
                            <form method="post">
                                <div class="pt-2 pb-2">
                                    <label>Username *</label>
                                    <input type="text" name="user_name" class="form-control p_input">
                                </div>
                                <div class="pt-2 pb-2">
                                    <label>Email *</label>
                                    <input type="email" name="user_email" class="form-control p_input">
                                </div>
                                <div class="pt-2 pb-2">
                                    <label>Phone *</label>
                                    <input type="text" name="user_phone" class="form-control p_input">      
                                </div>
                                <div class="pt-2 pb-2">
                                    <label>Role *</label>
                                    <select name="role_id" class="form-control p_input">
                                        <option value="">Select Role</option>
                                        <?php
                                        $sql = "SELECT role_id, role_type FROM roles WHERE role_type != 'Administrator'";
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
                                <div class="pt-2 pb-2">
                                    <label>Password *</label>
                                    <input type="password" name="user_password" class="form-control p_input">
                                </div>
                                <div class="pt-2 pb-2">
                                    <label>Confirm Password *</label>
                                    <input type="password" name="confirm_password" class="form-control p_input">
                                </div>

                                <div class="text-center d-grid gap-2">
                                    <button type="submit" name="registration" class="btn btn-primary btn-block enter-btn">Registration</button>
                                </div>

                                <p class="sign-up">Have an Account?<a href="login"> Login</a></p>
                            </form>
                            <!-- Script to get the role type from the selected role -->
                            <script src="../public/assets/vendors/js/twoinone.js"> </script>  
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