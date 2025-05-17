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
                $stmt = $mysqli->prepare("SELECT * FROM rooms WHERE room_id = ?");
                $stmt->bind_param('i', $room_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    $room = $res->fetch_object();
                } else {
                  
                    echo "<script>alert('Room not found'); window.location.href='rooms.php';</script>";
                }
                ?>
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Room Details </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Properties</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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