<?php
include(__DIR__ . '/../config/config.php');

// Correct order and no duplicates
require_once(__DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php');
require_once(__DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once(__DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php');


use PHPMailer\PHPMailer\Exception;

// Validate required variables from parent script
if (!isset($tenant_email, $tenant_name, $file_path, $file_name)) {
  error_log("Missing required variables for email");
  die("Error: Missing required email parameters");
}

/* Fetch Mailer Settings */
$ret = "SELECT * FROM mailer_settings LIMIT 1";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();

if ($mailer = $res->fetch_object()) {
  try {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->setFrom($mailer->mailer_mail_from_email);
    $mail->addAddress($tenant_email);
    $mail->FromName = $mailer->mailer_mail_from_name;
    $mail->isHTML(true);
    $mail->IsSMTP();
    $mail->SMTPSecure = $mailer->mailer_protocol;
    $mail->Host = $mailer->mailer_host;
    $mail->SMTPAuth = true;
    $mail->Port = $mailer->mailer_port;
    $mail->Username = $mailer->mailer_username;
    $mail->Password = $mailer->mailer_password;
    $mail->Subject = 'Monthly Rental Invoice';
    $mail->Body = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Monthly Rental Invoice</title>
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
    <h1>Monthly Rental Invoice</h1>
  </div>
  <div class="content">
    <h2>Hello ' . htmlspecialchars($tenant_name) . ',</h2>
    <p>Your monthly rental invoice is attached to this email. Please review the details and ensure payment is made by the due date.</p>
    <p>If you have any questions or need assistance, feel free to reach out to our support team. We are here to help you every step of the way.</p>
  </div>
  <div class="footer">
    <p>Thank you for choosing Rental Management System.</p>
    <p>1234 Main Street, Anytown, Kenya</p>
    <p>Contact us: <a href="mailto:support@rentalmanagement.com">support@rentalmanagement.com</a></p>
  </div>
  </div>
</body>
</html>';

    // Send email
    $mail->send();
    error_log("Invoice email sent successfully to: " . $tenant_email);
  } catch (Exception $e) {
    error_log("Email sending failed: {$mail->ErrorInfo}");
    // Don't die - continue processing other invoices
  }
} else {
  error_log("No mailer settings found in database");
}

$stmt->close();
