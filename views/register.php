

<?php
//connection from DB
include("../config/config.php");
require '../vendor/autoload.php'; // Include PHPMailer autoload file


    //registration
    if (isset($_POST['registration'])) {
    
        // Declaration of variables
        $user_name = mysqli_real_escape_string($mysqli, $_POST['user_name']);
        $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
        $user_phone = mysqli_real_escape_string($mysqli, $_POST['user_phone']);
        $user_password = mysqli_real_escape_string($mysqli, $_POST['user_password']);
        $confirm_password = mysqli_real_escape_string($mysqli, $_POST['confirm_password']);
        $role_id = mysqli_real_escape_string($mysqli, $_POST['role_id']);
        $user_role = mysqli_real_escape_string($mysqli, $_POST['role_type']);

        // Check if passwords match
        if ($user_password !== $confirm_password) {
            $err = "Passwords do not match!";
            echo $err;
            return;
        }

        // Check if email already exists
        $check_email = $mysqli->query("SELECT * FROM users WHERE user_email = '$user_email'");
        if ($check_email->num_rows > 0) {
            $err = "Email already registered!";
          
          
        }

        // Hash password
        $password = password_hash($user_password, PASSWORD_DEFAULT);

        // Insert user into the database
        $sql = "INSERT INTO users (user_name, user_email, user_password, role_id) 
            VALUES('$user_name', '$user_email', '$password', '$role_id')";

        if ($mysqli->query($sql)) {
            // Include mailer script
            include('../mailers/user_onboarding.php');

            try {
                if ($mail->send()) {
                    $success = "Registration Successful! Please check your email for login details.";
                    header("Location: login");
                    exit;
                } else {
                    $info = "Registration Successful, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    
                }
            } catch (Exception $e) {
                $err="Registration Successful, but email could not be sent. Exception: {$e->getMessage()}";
            }
        } else {
            $err="Registration Failed! Please try again.";
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
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const roleSelect = document.querySelector('select[name="role_id"]');
                                    const roleTypeInput = document.getElementById('role_type');

                                    if (roleSelect && roleTypeInput) {
                                        roleSelect.addEventListener('change', function() {
                                            const selectedOption = this.options[this.selectedIndex];
                                            const roleType = selectedOption.getAttribute('data-role-type') || '';
                                            roleTypeInput.value = roleType;
                                        });
                                    }
                                });
                            </script>  
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