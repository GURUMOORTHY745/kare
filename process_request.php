<?php
session_start();
require 'connect.php'; // Database connection
require 'vendor/autoload.php'; // Composer autoload for PHPMailer and Twilio

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donor_id = $_POST['donor_id'];
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];

    // Fetch request details from the database
    // Fetch request details from the database
$query = $db->prepare("SELECT br.*, dr.email AS donor_email, dr.phone AS donor_phone 
                       FROM blood_request br
                       JOIN donor_registration dr ON br.username = dr.donor_id
                       WHERE br.id = :request_id");
    $query->bindParam(':request_id', $request_id, PDO::PARAM_INT);
    $query->execute();
    $request = $query->fetch(PDO::FETCH_ASSOC);

    if ($request) {
        // Get request details
        $email = $request['email']; // Requester's email
        $phone = $request['phone']; // Requester's phone
        $blood_type = $request['blood_type'];
        $units = $request['units'];
        $hospital = $request['hospital'];
        $city = $request['city'];
        $reason = $request['reason'];

        // Get donor details
        $donor_email = $request['donor_email'];
        $donor_phone = $request['donor_phone'];

        // Show alert with fetched details
        
        // Set request status
        $status = ($action === 'accept') ? 'accepted' : 'rejected';
        $updateQuery = $db->prepare("UPDATE blood_request SET status = :status WHERE id = :request_id");
        $updateQuery->bindParam(':status', $status, PDO::PARAM_STR);
        $updateQuery->bindParam(':request_id', $request_id, PDO::PARAM_INT);
        $updateQuery->execute();

        // Send email and SMS to both requester and donor
        sendNotificationEmails($email, $donor_email, $units, $blood_type, $status, $hospital, $city, $reason);
        sendNotificationSMS($phone, $donor_phone, $units, $blood_type, $status, $hospital);

        // Set a status message for feedback
        $_SESSION['status_message'] = "Request has been {$status} successfully!";
    } else {
        $_SESSION['status_message'] = "Request not found.";
    }

    // Redirect back to manage requests page
    header('Location: manage_requests.php'); 
    exit;
}

// Function to send notification emails
function sendNotificationEmails($email, $donor_email, $units, $blood_type, $status, $hospital, $city, $reason) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'guruda7777@gmail.com'; // SMTP username
        $mail->Password = 'tndk jgrm zvrs ftcl'; // SMTP password (use app password if using Gmail with 2FA)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('guruda7777@gmail.com', 'Blood Donation System');
        $mail->addAddress($email); // Add requester's email
        $mail->addAddress($donor_email); // Add donor's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Blood Request ' . ucfirst($status);
        $mail->Body = "Hello,<br><br>Your blood request for <strong>{$units} units of {$blood_type}</strong> has been <strong>{$status}</strong>.<br>
                       Hospital: {$hospital}<br>City: {$city}<br>Reason: {$reason}<br><br>Thank you!";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error : {$mail->ErrorInfo}");
    }
}

// Function to send notification SMS
function sendNotificationSMS($phone, $donor_phone, $units, $blood_type, $status, $hospital) {
    $sid = 'AC61e828fb385db3a170614caa89f9c7dd';
    $token = '6dc11a47495e9d9b9c48658fd9015aa7';
    $twilio_number = '+19293252229'; // Your Twilio number
    $client = new Client($sid, $token);

    $smsMessage = "Hello, your blood request for {$units} units of {$blood_type} has been {$status}. Hospital: {$hospital}.";

    try {
        $client->messages->create($phone, [
            'from' => $twilio_number,
            'body' => $smsMessage
        ]);
        $client->messages->create($donor_phone, [
            'from' => $twilio_number,
            'body' => $smsMessage
        ]);
    } catch (Exception $e) {
        error_log("SMS could not be sent: " . $e->getMessage());
    }
}
?>