<?php

require_once('../config/config.php');
require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
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
  $mail->addAddress($property_manager_email);
  $mail->FromName = $mailer->mailer_mail_from_name;
  $mail->isHTML(true);
  $mail->IsSMTP();
  $mail->SMTPSecure = $mailer->mailer_protocol;
  $mail->Host = $mailer->mailer_host;
  $mail->SMTPAuth = true;
  $mail->Port = $mailer->mailer_port;
  $mail->Username = $mailer->mailer_username;
  $mail->Password = $mailer->mailer_password;
  $mail->Subject = 'Requst for Maintenance';

  /* Custom Mail Body */
  $mail->Body = '<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Request for Maintenance</title>
    <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
      color: #333;
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .header {
      background-color: #007bff;
      color: #ffffff;
      text-align: center;
      padding: 20px;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
    }

    .content {
      padding: 20px;
    }

    .content h2 {
      color: #007bff;
      font-size: 20px;
      margin-bottom: 10px;
    }

    .content p {
      font-size: 16px;
      line-height: 1.6;
      margin: 10px 0;
    }

    .button-container {
      text-align: center;
      margin: 20px 0;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      color: #ffffff;
      background-color: #007bff;
      text-decoration: none;
      border-radius: 5px;
    }

    .button:hover {
      background-color: #0056b3;
    }

    .footer {
      background-color: #f8f9fa;
      text-align: center;
      padding: 15px;
      font-size: 14px;
      color: #666;
    }

    .footer p {
      margin: 5px 0;
    }

    .footer a {
      color: #007bff;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }
    </style>
  </head>

  <body>
    <div class="container">
    <div class="header">
      <h1>Request for Maintenance</h1>
    </div>
    <div class="content">
      <h2>Hello ' . $property_manager_name . ',</h2>
      <p>You have a pending request for maintenance by ' . $tenant_name . '  for ' . $room_title . '.  </p>
      <p>Please Login to process the request.</p>
    </div>
    <div class="footer">
      <p>Thank you for choosing Rental Management System.</p>
      <p>1234 Main Street, Anytown, Kenya</p>
      <p>Contact us: <a href="mailto:support@rentalmanagement.com">support@rentalmanagement.com</a></p>
    </div>
    </div>
  </body>

  </html>';
}
