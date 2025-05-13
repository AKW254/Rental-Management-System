<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');
// Set response header
header('Content-Type: application/json');

$response = ['success' => false];

if (!isset($_SESSION['user_id'])) {
    $response['error'] = 'Unauthorized access.';
    echo json_encode($response);
    exit;
}

//Declare variables
$user_name = trim($_POST['user_name'] ?? '');
$user_email = trim($_POST['user_email'] ?? '');
$user_phone = trim($_POST['user_phone'] ?? '');
$role_id = trim($_POST['role_id'] ?? '');
$role_type = trim($_POST['role_type'] ?? '');



//Generate default password which Mets password
$user_password= $user_gen_password;
//Hash the password
$user_hash_password = password_hash($user_password, PASSWORD_DEFAULT);
//Create User
$sql="INSERT INTO users (user_name, user_email, user_phone, user_password, role_id) VALUES ('$user_name', '$user_email', '$user_phone', '$user_hash_password', '$role_id')";
$stmt=$mysqli->prepare($sql);
if ($stmt->execute()) {
    include('../mailers/user_onboarding.php');
    if($mail->send()){
        $response['success'] = true;
        $response['message'] = 'User created successfully. Please check your email for the password.';
    } else {
        $response['error'] = 'User created, but email not sent: ' . $mail->ErrorInfo;
    }

    $response['success'] = true;
    $response['message'] = 'User created successfully.';
    echo json_encode($response);
    exit;
} else {
    $response['error'] = 'Failed to create user.';
    echo json_encode($response);
    exit;
}   