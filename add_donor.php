<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Include your database connection file
require 'connect.php';

// Include the PHPMailer class and Twilio SDK
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Assuming Composer's autoloader is in the same folder

// Function to send rejection email via SMTP
function sendRejectionEmail($email) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through (example: Gmail, SendGrid, etc.)
        $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
       $mail->Username   = 'guruda7777@gmail.com';                 // SMTP username
        $mail->Password   = 'tndk jgrm zvrS ftcl';                        // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
        $mail->Port       = 587;                                      // TCP port to connect to (usually 587 for TLS)

        // Recipients
        $mail->setFrom('no-reply@donationplatform.com', 'Donation Platform');
        $mail->addAddress($email);  // Add the recipient's email address

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Donor Registration Rejected';
        $mail->Body    = 'Dear Donor,<br><br>We regret to inform you that your registration has been rejected because your email address is already associated with an existing donor account.<br><br>Thank you for your understanding.<br><br>Best Regards,<br>The Donation Team';

        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to send SMS via Twilio
function sendRejectionSMS($phone) {
    // Twilio credentials
 $sid = 'AC61e828fb385db3a170614caa89f9c7dd';
    $token = '6dc11a47495e9d9b9c48658fd9015aa7';
    $twilio_phone_number = '+19293252229';

    // Initialize Twilio client
    $client = new Twilio\Rest\Client($sid, $token);

    try {
        // Send SMS
        $client->messages->create(
            $phone, // Recipient's phone number
            [
                'from' => $twilio_phone_number, // Your Twilio phone number
                'body' => 'We regret to inform you that your registration has been rejected because your phone number is already associated with an existing donor account.'
            ]
        );
    } catch (Exception $e) {
        echo "SMS could not be sent. Error: {$e->getMessage()}";
    }
}

// Fetch pending donors
$pending_donors = $db->query("SELECT * FROM pending_donors")->fetchAll(PDO::FETCH_ASSOC);

// Handle approval or rejection
if (isset($_POST['action'])) {
    $donor_id = $_POST['donor_id'];

    // Check if email and phone are set before accessing them
    $donor_email = isset($_POST['email']) ? $_POST['email'] : null;
    $donor_phone = isset($_POST['phone']) ? $_POST['phone'] : null;

    if ($_POST['action'] === 'approve') {
        // Check if the email already exists in the donor registration table
        if ($donor_email) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM donor_registration WHERE email = :email");
            $stmt->bindValue(':email', $donor_email);
            $stmt->execute();
            $email_count = $stmt->fetchColumn();

            if ($email_count > 0) {
                // Email already exists, reject the donor and send an email and SMS to inform them
                sendRejectionEmail($donor_email);
                if ($donor_phone) {
                    sendRejectionSMS($donor_phone);
                }

                // Remove from pending donors
                $db->prepare("DELETE FROM pending_donors WHERE donor_id = :donor_id")->execute([':donor_id' => $donor_id]);

                echo "<script>alert('This email is already registered. Donor registration has been rejected. An email and SMS have been sent to the donor.');</script>";
            } else {
                // Move donor from pending to actual donors table
                $stmt = $db->prepare("INSERT INTO donor_registration (donor_id, email, phone, city, blood_type)
                                      SELECT donor_id, email, phone, city, blood_type
                                      FROM pending_donors WHERE donor_id = :donor_id");
                $stmt->bindValue(':donor_id', $donor_id);
                $stmt->execute();

                // Remove from pending donors
                $db->prepare("DELETE FROM pending_donors WHERE donor_id = :donor_id")->execute([':donor_id' => $donor_id]);

                echo "<script>alert('Donor approved successfully!');</script>";
            }
        } else {
            echo "<script>alert('Email not provided!');</script>";
        }
    } elseif ($_POST['action'] === 'reject') {
        // Remove from pending donors
        $db->prepare("DELETE FROM pending_donors WHERE donor_id = :donor_id")->execute([':donor_id' => $donor_id]);
        echo "<script>alert('Donor registration rejected.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Donors - Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Pending Donor Registrations</h1>
    <table>
        <tr>
            <th>Donor ID</th>
            <th>Email</th>
            <th>Phone</th>
            <th>City</th>
            <th>Blood Type</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pending_donors as $donor): ?>
            <tr>
                <td><?php echo htmlspecialchars($donor['donor_id']); ?></td>
                <td><?php echo htmlspecialchars($donor['email']); ?></td>
                <td><?php echo htmlspecialchars($donor['phone']); ?></td>
                <td><?php echo htmlspecialchars($donor['city']); ?></td>
                <td><?php echo htmlspecialchars($donor['blood_type']); ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="donor_id" value="<?php echo htmlspecialchars($donor['donor_id']); ?>">
                        <input type="hidden" name="email" value="<?php echo htmlspecialchars($donor['email']); ?>">
                        <input type="hidden" name="phone" value="<?php echo htmlspecialchars($donor['phone']); ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                        <button type="submit" name="action" value="reject">Reject</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
