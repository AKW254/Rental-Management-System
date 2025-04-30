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
        <di class="container-fluid page-body-wrapper">
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
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Property</th>
                                                                <th>Room No</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch rent history from the database

                                                            $query = "SELECT rs.room_title, ps.property_name, ra.agreement_start_date, ra.agreement_end_date 
                                                                  FROM rooms AS rs 
                                                                  INNER JOIN rental_agreements AS ra ON rs.room_id = ra.room_id 
                                                                  INNER JOIN properties AS ps ON rs.property_id = ps.property_id 
                                                                  WHERE ra.tenant_id = ? AND ra.agreement_end_date IS NOT NULL 
                                                                  ORDER BY ra.agreement_created_at DESC LIMIT 5";
                                                            $stmt = $mysqli->prepare($query);
                                                            $stmt->bind_param('i', $user_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $count = 1;

                                                            if ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $count++ . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['room_title']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['property_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['agreement_start_date']))) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['agreement_end_date']))) . "</td>";
                                                                echo "</tr>";
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No rent history found.</td></tr>";
                                                            }

                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="paymentHistory">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Payment Method</th>
                                                                <th>Payment Status</th>
                                                                <th>Payment Date</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch payment history from the database
                                                            $query = "SELECT pm.payment_method,pm.payment_status,pm.payment_created_at,pm.payment_amount 
                                                                      FROM payments AS pm 
                                                                      INNER JOIN invoices AS ins ON ins.invoice_id = pm.invoice_id 
                                                                      INNER JOIN rental_agreements AS rs ON rs.agreement_id = ins.agreement_id 
                                                                  WHERE rs.tenant_id = ? 
                                                                  ORDER BY pm.payment_date DESC LIMIT 5";
                                                            $stmt = $mysqli->prepare($query);
                                                            $stmt->bind_param('i', $user_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $count = 1;

                                                            if ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $count++ . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['property_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['room_title']) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['payment_date']))) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
                                                                echo "</tr>";
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No payment history found.</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="maintenanceRequests">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Request Type</th>
                                                                <th>Status</th>
                                                                <th>Request Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch maintenance requests from the database
                                                            $query = "SELECT mr.maintenance_request_description,mr.maintenance_request_status,mr.maintenance_request_submitted_at FROM maintenance_requests AS mr
                                                                     INNER JOIN rental_agreements AS ra ON ra.agreement_id=mr.agreement_id 
                                                                      WHERE ra.tenant_id = ? 
                                                                      ORDER BY mr.maintenance_request_submitted_at DESC LIMIT 5";
                                                            $stmt = $mysqli->prepare($query);
                                                            $stmt->bind_param('i', $user_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $count = 1;

                                                            if ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $count++ . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['request_type']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['request_date']))) . "</td>";
                                                                echo "</tr>";
                                                            } else {
                                                                echo "<tr><td colspan='4' class='text-center'>No maintenance requests found.</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="propertyHistory">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Property Name</th>
                                                                <th>Property location</th>
                                                                <th>Since</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch property history from the database
                                                            $query = "SELECT property_name,property_location,property_created_at FROM properties
                                                                     WHERE property_manager_id =?
                                                                      ORDER BY property_created_at DESC";
                                                            $stmt = $mysqli->prepare($query);
                                                            $stmt->bind_param('i', $user_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $count = 1;

                                                            if ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $count++ . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['property_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['property_location']) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['property_created_at']))) . "</td>";
                                                               
                                                                echo "</tr>";
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No property history found.</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="rentalAgreements">
                                                    <table class="table table-bordered">                                                       
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Property</th>
                                                                <th>Room No</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            // Fetch property history from the database
                                                            $query = "SELECT ps.property_name,rm.room_title,ra.agreement_start_date,ra.agreement_end_date FROM rental_agreements AS ra 
                                                                      INNER JOIN rooms AS rm ON rm.room_id=ra.room_id
                                                                      INNER JOIN properties AS ps ON ps.property_id=ra.room_id
                                                                      WHERE ra.tenant_id =?
                                                                      ORDER BY agreement_created_at DESC";
                                                            $stmt = $mysqli->prepare($query);
                                                            $stmt->bind_param('i', $user_id);
                                                            $stmt->execute();
                                                            $result = $stmt->get_result();
                                                            $count = 1;

                                                            if ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $count++ . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['property_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['room_title']) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['property_created_at']))) . "</td>";
                                                                echo "<td>" . htmlspecialchars(date('d M Y', strtotime($row['property_created_at']))) . "</td>";
                                                                echo "</tr>";
                                                            } else {
                                                                echo "<tr><td colspan='5' class='text-center'>No Rental history found.</td></tr>";
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane fade" id="accountupdate">
                                                    <form id="accountUpdateForm">
                                                        <div class="form-group">
                                                            <label for="userName">Name</label>
                                                            <input type="text" class="form-control" id="userName" name="user_name" value="<?php echo $_SESSION['user_name']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="userEmail">Email</label>
                                                            <input type="email" class="form-control" id="userEmail" name="user_email" value="<?php echo $_SESSION['user_email']; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="userPhone">Phone</label>
                                                            <input type="text" class="form-control" id="userPhone" name="user_phone" value="<?php echo $_SESSION['user_phone']; ?>" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Update Account</button>
                                                    </form>
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
            </div>
            <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
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