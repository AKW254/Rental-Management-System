<?php
//Start session
session_start();
require_once('../config/config.php');
include('../config/checklogin.php');


check_login()
//Check if user is logged in

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../partials/head.php') ?>


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
                <?php
                //Get room details
                $room_id = $_GET['room_id'];
                $stmt = $mysqli->prepare("SELECT rs.room_title,rs.room_image,rs.room_rent_amount,rs.room_availability,us.user_name AS landlord,user_pic,property_name FROM rooms AS rs 
                INNER JOIN properties AS ps ON rs.property_id=ps.property_id
                INNER JOIN users AS us ON ps.property_manager_id=us.user_id
                 WHERE room_id = ?");
                $stmt->bind_param('i', $room_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    $room = $res->fetch_object();
                    //Declare
                    if (!empty($room->user_pic)) {

                        $profile_photo = '../public/images/profiles/' . $room->user_pic;
                    } else {

                        $profile_photo = '../public/images/profiles/dummy_profile.jpg';
                    }
                ?>
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title"><?php echo $room->room_title; ?> Room Details </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">View Room details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-12">
                                        <!--Show Room details -->
                                        <div class="col-sm-12 col-md-12 col-xl-8 grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel owl-loaded owl-drag">
                                                        <div class="owl-stage-outer">
                                                            <div class="owl-stage">
                                                                <div class="owl-item active" style="width: 100%; margin-right: 5px;">
                                                                    <div class="item">
                                                                        <img src="../public/images/rooms/<?php echo $room->room_image ?>" class="img-fluid. max-width: 100% " alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex py-4">
                                                        <div class="preview-list w-100">
                                                            <div class="preview-item p-0">
                                                                <div class="preview-thumbnail">
                                                                    <img src="<?php echo $profile_photo ?>" class="rounded-circle" alt="">
                                                                </div>
                                                                <div class="preview-item-content d-flex flex-grow">
                                                                    <div class="flex-grow">
                                                                        <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                                                            <h6 class="preview-subject"><?php echo $room->landlord ?></h6>
                                                                            <p class="text-muted text-small">Landlord</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <h2>Basic inform about <?php echo $room->room_title; ?> </h2>
                                                                    <table class="table table-bordered table-responsive">
                                                                        <tr>
                                                                            <td><b>Room No:</b></td>
                                                                            <td><?php echo $room->room_title ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Monthly Rent:</b></td>
                                                                            <td>Ksh.<?php echo number_format($room->room_rent_amount, 2); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Property Name:</b></td>
                                                                            <td><?php echo $room->property_name; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td> <b>Room status:</b> </td>
                                                                            <td><?php echo $room->room_availability; ?></td>
                                                                        </tr>

                                                                    </table>
                                                                    <h2>Rental History</h2>
                                                                    <table class="table table-responsive table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>From</th>
                                                                                <th>To</th>
                                                                                <th>Rented by</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $sql = "SELECT * FROM rental_agreements AS ra 
                                                                        INNER JOIN users AS us ON ra.tenant_id=us.user_id
                                                                        WHERE room_id = ?";
                                                                            $stmt = $mysqli->prepare($sql);
                                                                            $stmt->bind_param('i', $room_id);
                                                                            $stmt->execute();
                                                                            $res = $stmt->get_result();
                                                                            //Get row count
                                                                            $row_count = $res->num_rows;
                                                                            if ($row_count == 0) {
                                                                                echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
                                                                            } else {
                                                                                $i = 0;
                                                                                while ($rental = $res->fetch_object()) {
                                                                                    $i++;
                                                                                    echo "<tr>";
                                                                                    echo "<td>" . $i . "</td>";
                                                                                    echo "<td>" . date('d M Y', strtotime($rental->rental_start_date)) . "</td>";
                                                                                    echo "<td>" . date('d M Y', strtotime($rental->rental_end_date)) . "</td>";
                                                                                    echo "<td>" . $rental->user_name . "</td>";
                                                                                    echo "<td>" . $rental->agreement_status . "</td>";
                                                                                    echo "</tr>";
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {

                    echo "<script>alert('Room not found'); window.location.href='rooms.php';</script>";
                }
                ?>

                <!-- main-panel ends -->
                <!-- container-scroller -->
                <?php include('../functions/custom_alerts.php'); ?>




                <!-- Include Toastr CSS -->
                <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

                <?php include('../partials/scripts.php') ?>

                <!-- Include Toastr JS -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>



</html>