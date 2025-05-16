<?php
session_start();
include('../config/config.php');
include('../config/checklogin.php');
check_login();
// Set response header   
header('Content-Type: application/json');
$response = ['success' => false];
if (!$_SESSION['user_id']) {
    $response = ['success' => false, 'message' => 'User not logged in'];
    echo json_encode($response);
    return;
}

// Handles the creation of a new room by validating inputs and inserting data into the database
if(isset($_POST['add_room'])){
    //Declare variables
    $room_title=mysqli_real_escape_string($mysqli,$_POST['room_title']);
    $room_image=mysqli_real_escape_string($msqli,$_FILES['room_image']['name']);
    $room_rent_amount=mysqli_real_escape_string($mysqli,$_POST['room_rent_amount']);
    $property_id=mysqli_real_escape_string($mysqli,$_POST['property_id']);
    //Check if Room Image is not null and store in directory
    if(isset($_FILES['room_image']['name']) && !empty($_FILES['room_image']['name'])){
        $room_image = uniqid() . "_" . $_FILES['room_image']['name'];
        $tmp_name = $_FILES['room_image']['tmp_name'];    
        move_uploaded_file($tmp_name,"../public/assets/images/rooms/".$room_image);    
    }
    //Check if a room exists
    $sql="SELECT * FROM rooms WHERE room_title='$room_title' AND property_id='$property_id'";
    $result=$mysqli->query($sql);
    if($result->num_rows > 0){
        $response = ['success' => false, 'message' => "Room already exists with title '$room_title' in property ID '$property_id'"];
        echo json_encode($response);
        return;
    }
    //Insert room into database
    $stmt = $mysqli->prepare("INSERT INTO rooms (room_title, room_image, room_rent_amount, property_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssdi", $room_title, $room_image, $room_rent_amount, $property_id);
    if($stmt->execute()){
        $room_id = $mysqli->insert_id; // Get the last inserted ID
        $response = ['success' => true, 'message' => "Room created successfully with ID: $room_id and Title: $room_title"];
        echo json_encode($response);
        exit;
    } else {
        error_log('Database Error: ' . $mysqli->error); // Log the error internally
        $response = ['success' => false, 'message' => 'An unexpected error occurred. Please try again later.'];
        echo json_encode($response);
        exit;
    }
}

//Edit Room
if(isset($_POST['edit_room'])){
    //Declare variables
    $room_id = $_POST['room_id'];
    $room_title = htmlspecialchars($_POST['room_title'], ENT_QUOTES, 'UTF-8');
    $room_image = $_FILES['room_image']['name'];
    $room_rent_amount = $_POST['room_rent_amount'];
    $property_id = $_POST['property_id'];
    //Check if Room Image is not null and store in directory
    if(isset($_FILES['room_image']['name']) && !empty($_FILES['room_image']['name'])){
        $room_image = uniqid() . "_" . $_FILES['room_image']['name'];
        $tmp_name = $_FILES['room_image']['tmp_name'];    
        move_uploaded_file($tmp_name, "../public/assets/images/rooms/".$room_image);
    }
    //Update room in database
    $stmt = $mysqli->prepare("UPDATE rooms SET room_title = ?, room_image = ?, room_rent_amount = ?, property_id = ? WHERE room_id = ?");
    $stmt->bind_param("ssdii", $room_title, $room_image, $room_rent_amount, $property_id, $room_id);
    if($stmt->execute()){
        $response = ['success' => true, 'message' => "Room updated successfully with Room No.: $room_title"];
        echo json_encode($response);
        exit;
    } else {
        $response = ['success' => false, 'message' => 'Error: ' . $mysqli->error];
        echo json_encode($response);
        exit;
    }   
}

//Delete rooom{
if(isset($_POST['delete_room'])){
    $room_id = filter_var($_POST['room_id'], FILTER_VALIDATE_INT);
    $room_title = mysqli_real_escape_string($mysqli, $_POST['room_title']);
    if($room_id === false){
        $response = ['success' => false, 'message' => 'Invalid Room ID'];
        echo json_encode($response);
        exit;
    }
    $stmt = $mysqli->prepare("DELETE FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    if($stmt->execute()){
        $response = ['success' => true, 'message' => "Room deleted successfully with Room No.: $room_title"];
        echo json_encode($response);
        exit;
    } else {
        $response = ['success' => false, 'message' => 'Error: ' . $mysqli->error];
        echo json_encode($response);
        exit;
    }
}