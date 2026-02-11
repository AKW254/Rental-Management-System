<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');
check_login()


?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>

<body class="sidebar-icon-only sidebar-fixed">
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <?php include('../partials/sidebar.php') ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="height: auto;">
            <!-- partial:partials/_navbar.html -->
            <?php include('../partials/navbar.php') ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php require_once('../helpers/analysis/tenant.php') ?>
                    <?php
                    require_once('../helpers/analysis/tenant_recommendations.php');
                    $recommendation_data = get_tenant_recommendations($mysqli, (int)$_SESSION['user_id'], 8, 8);
                    $recommended_rooms = $recommendation_data['recommended'];
                    $new_available_rooms = $recommendation_data['new_available'];
                    ?>
                    <div class="row g-4">
                        <!-- Total Rooms -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">No of Rented Rooms</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_rooms ?></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Active Agreements -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Active Agreements</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_agreements ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Maintenance -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Pending Maintenance</h6>
                                    <h3 class="fw-bold mb-0"><?php echo $total_maintenance ?></h3>
                                </div>
                            </div>
                        </div>
                        <!-- Total Rental Remittances -->
                        <div class="col-md-4 col-xl-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <h6 class="text-muted">Total Rental Remittances</h6>
                                    <h3 class="fw-bold mb-0">Ksh.<?php echo number_format($total_remittances, 2) ?></h3>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="container-fluid">
                        <h1 class="text-center mb-4  mt-3">Recommended Available Rooms</h1>
                        <div class="row g-4">
                            <?php if (empty($recommended_rooms)) { ?>
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">No personalized recommendations yet. Showing newly available rooms below.</div>
                                </div>
                            <?php } else { ?>
                                <?php foreach ($recommended_rooms as $room) { ?>
                                    <?php
                                    $room_image = !empty($room['room_image'])
                                        ? '../public/images/rooms/' . $room['room_image']
                                        : '../public/images/dummy room photo.jpg';
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-xl-3">
                                        <div class="card shadow-sm border-0 h-100">
                                            <img src="<?php echo htmlspecialchars($room_image); ?>" class="card-img-top" alt="Room image">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($room['room_title']); ?></h5>
                                                <p class="text-muted mb-1"><?php echo htmlspecialchars($room['property_name']); ?></p>
                                                <p class="mb-1"><strong>Ksh.<?php echo number_format((float)$room['room_rent_amount'], 2); ?></strong></p>
                                                <p class="text-muted mb-2"><?php echo htmlspecialchars($room['property_location']); ?></p>
                                                <p class="text-muted mb-2">Landlord: <?php echo htmlspecialchars($room['landlord_name']); ?></p>
                                                <a class="btn btn-sm btn-primary" href="room-details.php?room_id=<?php echo (int)$room['room_id']; ?>">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <?php if (!empty($new_available_rooms)) { ?>
                            <h2 class="text-center mb-4 mt-4">Newly Available Rooms</h2>
                            <div class="row g-4">
                                <?php foreach ($new_available_rooms as $room) { ?>
                                    <?php
                                    $room_image = !empty($room['room_image'])
                                        ? '../public/images/rooms/' . $room['room_image']
                                        : '../public/images/dummy room photo.jpg';
                                    ?>
                                    <div class="col-sm-12 col-md-6 col-xl-3">
                                        <div class="card shadow-sm border-0 h-100">
                                            <img src="<?php echo htmlspecialchars($room_image); ?>" class="card-img-top" alt="Room image">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($room['room_title']); ?></h5>
                                                <p class="text-muted mb-1"><?php echo htmlspecialchars($room['property_name']); ?></p>
                                                <p class="mb-1"><strong>Ksh.<?php echo number_format((float)$room['room_rent_amount'], 2); ?></strong></p>
                                                <p class="text-muted mb-2"><?php echo htmlspecialchars($room['property_location']); ?></p>
                                                <p class="text-muted mb-2">Landlord: <?php echo htmlspecialchars($room['landlord_name']); ?></p>
                                                <a class="btn btn-sm btn-outline-primary" href="room-details.php?room_id=<?php echo (int)$room['room_id']; ?>">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
                <?php include('../partials/footer.php') ?>
            </div>
            <!-- page-body-wrapper ends -->
        </div>
    </div>
    <?php include('../partials/scripts.php') ?>

</body>

</html>
