
<?php
require 'vendor/autoload.php'; // Include Composer autoload for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'guruda7777@gmail.com'; // SMTP username
        $mail->Password = 'tndk jgrm zvrs ftcl'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom('guruda7777@gmail.com', 'Blood Donation Team');
        $mail->addAddress($to); // Add a recipient

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        error_log('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo); // Log the error
        return false; // Email sending failed
    }
}
