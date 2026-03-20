<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../src/PHPMailer-master/src/Exception.php';
require __DIR__ . '/../src/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../src/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: text/plain; charset=utf-8');

// If you open this file in browser (GET), just show a message (NOT 500)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(200);
  exit("contact.php is working. Please submit the contact form.");
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $subject === '' || $message === '') {
  http_response_code(400);
  exit("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  exit("Invalid email address.");
}

$accountEmail = "javefryango.qgc@gmail.com";
$accountPass  = "bvqmjtoojbuiucsb"; // ⚠️ generate a NEW one (you exposed the old one)

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->SMTPDebug  = 2;          // shows SMTP error details
  $mail->Debugoutput = 'error_log';

  $mail->Host       = 'smtp.gmail.com';
  $mail->SMTPAuth   = true;
  $mail->Username   = $accountEmail;
  $mail->Password   = $accountPass;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
  $mail->Port       = 587;

  $mail->setFrom($accountEmail, 'LFPDMS Contact Form');
  $mail->addAddress($accountEmail);
  $mail->addReplyTo($email, $name);

  $mail->Subject = "[LFPDMS] " . $subject;
  $mail->Body =
    "Name: $name\n" .
    "Email: $email\n\n" .
    "Message:\n$message\n";

  $mail->send();
  echo "OK";
} catch (Exception $e) {
  http_response_code(500);
  echo "Mailer Error: " . $mail->ErrorInfo;
}
