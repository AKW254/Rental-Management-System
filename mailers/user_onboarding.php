<?php

require_once('../config/config.php');
/* Mailer Configurations */
require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
require_once('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once('../vendor/phpmailer/phpmailer/src/Exception.php');

/* Fetch Mailer Settings And System Settings Too */
$ret = "SELECT * FROM mailer_settings";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($mailer = $res->fetch_object()) {

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->setFrom($mailer->mailer_mail_from_email);
    $mail->addAddress($user_email);
    $mail->FromName = $mailer->mailer_mail_from_name;
    $mail->isHTML(true);
    $mail->IsSMTP();
    $mail->SMTPSecure = $mailer->mailer_protocol;
    $mail->Host = $mailer->mailer_host;
    $mail->SMTPAuth = true;
    $mail->Port = $mailer->mailer_port;
    $mail->Username = $mailer->mailer_username;
    $mail->Password = $mailer->mailer_password;
    $mail->Subject = 'Welcome Aboard';
    /* Custom Mail Body */
    $mail->Body = '<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Rental Management System</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #e7e7e7;
      color: #000;
      font-family: \'Raleway\', sans-serif;
    }

    .u-row-container {
      padding: 0;
      background-color: transparent;
    }

    .u-row {
      margin: 0 auto;
      max-width: 600px;
      background-color: transparent;
    }

    .u-col {
      display: table-cell;
      vertical-align: top;
      width: 100%;
    }


    .u-text-center {
      text-align: center;
    }

    .u-padding {
      padding: 8px;
    }

    .u-button {
      display: inline-block;
      text-decoration: none;
      color: #000;
      background: #ffce00;
      border-radius: 25px;
      padding: 10px 20px;
      font-size: 14px;
      font-weight: bold;
    }

    .u-divider {
      border-top: 3px solid #f3dede;
      margin: 10px 0;
    }

    .u-footer-divider {
      border-top: 1px solid #BBBBBB;
      margin: 20px 0;
    }

    @media (max-width: 620px) {
      .u-row {
        width: 100% !important;
      }

      .u-col {
        display: block;
        width: 100% !important;
      }
    }
  </style>
</head>

<body>
  <div class="u-row-container">
    <div class="u-row">
      <div class="u-col" style="background-color: #ffffff;">
        <div class="u-text-center">
          <h1 style="font-size: 40px; line-height: 56px; margin: 0;">RENTAL MANAGEMENT SYSTEM</h1>
        </div>
        <div class="u-text-center">
            <p style="font-size: 20px; line-height: 30px;">The best rental management system for your property</p>
            <img src="https://media-hosting.imagekit.io//e12fc20d2a9b4b26/image-1.png?Expires=1836639249&Key-Pair-Id=K2ZIVPTIP2VGHC&Signature=zNqkSJMFpRCvqI2aYcPCHtrHAzK~vhsaEHDFwQWYwylEhv~~k6~kqDV9H-zQo4pmcvShSmgd~8zDibLlAQprzBfhT~9i15h3Yon8ufw-SqZEXGumwx10fC9kAtnWzAk8aUN0wLX4ARXE776D59hltLOu3bmpKQzKXHfAi1RT5kGwQkKQFfXxVFNUghhusoSqhg-IvM-WaFGc3a80UEXMdbT0gZaNrVK1ZuAAMu3biHv0~k2m1Cb3RGvXDEMazYTwGqcDmh2-TQ8K6MO0k5gSowlxESPSpIPw623JeRyYiUiSV81tCsHxK-X6qirGrGG8onJ3-Pa5QDCrW8h37HITpQ__" alt="Rental Management System" style="width: 80%; max-width: 480px; height: auto; max-height: 300px; display: block; margin: 0 auto;">
        </div>
      </div>
    </div>
  </div>

  <div class="u-row-container">
    <div class="u-row">
      <div class="u-col" style="background-color: #f6f6f6;">
        <div class="u-padding u-text-center">
          <h2>Welcome Onboard ' . $user_name . '!</h2>
        </div>
        
        <div class="u-padding u-text-center">
          <p>We are so glad for you to join Rental Management System as '. $user_role. '.</p>
          <p>We can click to proceed to login .</p>
           <div class="u-text-center">
          <a href="localhost/Rms/views/login" class="u-button">Login</a>
        </div>
        </div>
        <div class="u-divider"></div>
        <div class="u-padding u-text-center">
            <ul style="list-style-type: none; padding: 0; margin: 0;">
              <li><i><b style="font-size: 16px;">Thank you for choosing Rental Management System</b></i></li>
              <li><i><b style="font-size: 16px;">Rental Management System</b></i></li>
              <li><i><b style="font-size: 16px;">1234 Main Street, Anytown, USA</b></i></li>
              <li><i><b style="font-size: 16px;">Contact us: support@rentalmanagement.com</b></i></li>
            </ul>
        </div>
      </div>
    </div>
    
  </div>
</body>

</html>';
}
