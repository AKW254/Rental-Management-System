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
                                                            <a class="nav-link" href="#paymentHistory" data-bs-toggle="tab">
                                                                Payment History </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#maintenanceRequests" data-bs-toggle="tab">
                                                                Maintenance Request History </a>
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

                                            <div class="tab-content mt-2">
                                                <div class="tab-pane fade show active" id="rentHistory">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <h4 class="card-title">Room Rent History</h4>
                                                                <p class="text-muted mb-1 small"><a href="rental_history.php">View all</a></p>
                                                            </div>

                                                            <?php
                                                            $sql = "SELECT 
                        r.room_image, 
                        r.room_title, 
                        pr.property_name, 
                        rl.agreement_status,
                        rl.agreement_created_at AS agreement_created_at
                    FROM 
                        rooms AS r
                    INNER JOIN 
                        rental_agreements AS rl ON r.room_id = rl.room_id
                    INNER JOIN 
                        users AS us ON rl.tenant_id = us.user_id
                    INNER JOIN 
                        properties AS pr ON pr.property_id = r.property_id
                    WHERE 
                        rl.tenant_id = '" . $_SESSION['user_id'] . "'
                    ORDER BY 
                        rl.agreement_created_at DESC";

                                                            $result = $mysqli->query($sql) or die("Error: " . $mysqli->error);

                                                            if ($result->num_rows > 0) {
                                                                echo '<div class="preview-list">';
                                                                while ($row = $result->fetch_array()) {
                                                            ?>
                                                                    <div class="preview-item border-bottom">
                                                                        <div class="preview-thumbnail">
                                                                            <img src="<?php echo $row['room_image']; ?>" alt="Room Image" class="rounded-circle">
                                                                        </div>
                                                                        <div class="preview-item-content d-flex flex-grow">
                                                                            <div class="flex-grow">
                                                                                <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                                                    <h6 class="preview-subject">Room No: <?php echo $row['room_title']; ?></h6>
                                                                                </div>
                                                                                <p class="text-muted">Property: <?php echo $row['property_name']; ?></p>
                                                                                <p class="text-muted">Status: <?php echo $row['agreement_status']; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            <?php
                                                                }
                                                                echo '</div>'; // close preview-list
                                                            } else {
                                                                echo '<div class="px-4 py-3">No Rent History Found</div>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="propertyHistory">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <h4 class="card-title mb-1">Property History</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="preview-list">
                                                                        <?php
                                                                        $sql = "SELECT
                                    pr.property_name,
                                    pr.property_location,
                                    pr.property_created_at AS property_created_at
                                FROM properties AS pr
                                WHERE pr.property_manager_id = '" . $_SESSION['user_id'] . "'
                                ORDER BY pr.property_created_at DESC";

                                                                        $result2 = $mysqli->query($sql);

                                                                        if ($result2->num_rows > 0) {
                                                                            while ($row = $result2->fetch_array()) {
                                                                        ?>
                                                                                <div class="preview-item border-bottom">
                                                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                                                        <div class="flex-grow">
                                                                                            <h6 class="preview-subject">Property Name: <?php echo $row['property_name']; ?></h6>
                                                                                            <p class="text-muted mb-0">Location: <?php echo $row['property_location']; ?></p>
                                                                                            <p class="text-muted mb-0">Created: <?php echo date('jS M Y', strtotime($row['property_created_at'])); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo '<div class="px-4 py-3">No Property History Found</div>';
                                                                        }
                                                                        ?>
                                                                    </div> <!-- preview-list -->
                                                                </div> <!-- col-12 -->
                                                            </div> <!-- row -->
                                                        </div> <!-- card-body -->
                                                    </div> <!-- card -->
                                                </div> <!-- tab-pane -->

                                                <div class="tab-pane fade" id="rentalAgreements">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <h4 class="card-title mb-1">Rental Agreements</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="preview-list">
                                                                        <?php
                                                                        $sql = "SELECT
                                                                            rl.agreement_id,
                                                                            rl.agreement_no,
                                                                            rl.agreement_status,
                                                                            rl.agreement_created_at,
                                                                            pr.property_name,
                                                                            r.room_title
                                                                        FROM rental_agreements AS rl
                                                                        INNER JOIN rooms AS r ON rl.room_id = r.room_id
                                                                        INNER JOIN properties AS pr ON r.property_id = pr.property_id
                                                                        WHERE rl.tenant_id = '" . $_SESSION['user_id'] . "'
                                                                        ORDER BY rl.agreement_created_at DESC";

                                                                        $result3 = $mysqli->query($sql);

                                                                        if ($result3->num_rows > 0) {
                                                                            while ($row = $result3->fetch_array()) {
                                                                        ?>
                                                                                <div class="preview-item border-bottom">
                                                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                                                        <div class="flex-grow">
                                                                                            <h6 class="preview-subject">Agreement No: <?php echo $row['agreement_no']; ?></h6>
                                                                                            <p class="text-muted mb-0">Property: <?php echo $row['property_name']; ?></p>
                                                                                            <p class="text-muted mb-0">Room No: <?php echo $row['room_title']; ?></p>
                                                                                            <p class="text-muted mb-0">Status: <?php echo $row['agreement_status']; ?></p>
                                                                                            <p class="text-muted mb-0">Created: <?php echo date('jS M Y', strtotime($row['agreement_created_at'])); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo '<div class="px-4 py-3">No Rental Agreements Found</div>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="tab-pane fade" id="paymentHistory">
                                                    <h4>Payment History</h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <h4 class="card-title mb-1">Payment History</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="preview-list">
                                                                        <?php
                                                                        $sql = "SELECT
                                                                            payment_invoice_no,
                                                                            payment_method,
                                                                            payment_amount,
                                                                            payment_date
                                                                        FROM payments
                                                                        WHERE user_id = '" . $_SESSION['user_id'] . "'
                                                                        ORDER BY payment_date DESC";

                                                                        $result = $mysqli->query($sql);

                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_array()) {
                                                                        ?>
                                                                                <div class="preview-item border-bottom">
                                                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                                                        <div class="flex-grow">
                                                                                            <h6 class="preview-subject">Invoice No: <?php echo $row['payment_invoice_no']; ?></h6>
                                                                                            <p class="text-muted mb-0">Method: <?php echo $row['payment_method']; ?></p>
                                                                                            <p class="text-muted mb-0">Amount: $<?php echo number_format($row['payment_amount'], 2); ?></p>
                                                                                            <p class="text-muted mb-0">Date: <?php echo date('jS M Y', strtotime($row['payment_date'])); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo '<div class="px-4 py-3">No Payment History Found</div>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="maintenanceRequests">
                                                    <h4>Maintenance Request History</h4>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="d-flex flex-row justify-content-between">
                                                                <h4 class="card-title mb-1">Maintenance Requests</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="preview-list">
                                                                        <?php
                                                                        $sql = "SELECT
                                                                            mr.maintenance_request_id,
                                                                            mr.maintenance_request_description,
                                                                            mr.maintenance_request_status,
                                                                            mr.maintenance_request_submitted_at,
                                                                            pr.property_name,
                                                                            r.room_title
                                                                        FROM maintenance_requests AS mr
                                                                        INNER JOIN rental_agreements AS ra ON ra.agreement_id = mr.agreement_id
                                                                        INNER JOIN rooms AS rm ON rm.room_id = ra.room_id
                                                                        INNER JOIN properties AS pr ON pr.property_id = rm.property_id
                                                                        INNER JOIN users AS us ON us.user_id = ra.tenant_id
                                                                        WHERE mr.tenant_id = '" . $_SESSION['user_id'] . "' 
                                                                        AND ra.tenant_id = '" . $_SESSION['user_id'] . "'
                                                                        ORDER BY mr.request_created_at DESC";

                                                                        $result = $mysqli->query($sql);

                                                                        if ($result->num_rows > 0) {
                                                                            while ($row = $result->fetch_array()) {
                                                                        ?>
                                                                                <div class="preview-item border-bottom">
                                                                                    <div class="preview-item-content d-sm-flex flex-grow">
                                                                                        <div class="flex-grow">
                                                                                            <h6 class="preview-subject">Request Title: <?php echo $row['maintenance_request_description']; ?></h6>
                                                                                            <p class="text-muted mb-0">Property: <?php echo $row['property_name']; ?></p>
                                                                                            <p class="text-muted mb-0">Room No: <?php echo $row['room_title']; ?></p>
                                                                                            <p class="text-muted mb-0">Status: <?php echo $row['request_status']; ?></p>
                                                                                            <p class="text-muted mb-0">Created: <?php echo date('jS M Y', strtotime($row['request_created_at'])); ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo '<div class="px-4 py-3">No Maintenance Requests Found</div>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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