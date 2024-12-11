<?php
include('connect.php'); // Ensure this file establishes a connection to your database
session_start();
require 'vendor/autoload.php'; // Ensure Composer's autoloader is included

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client; // Import Twilio Client

// Twilio credentials (consider using environment variables for security)
$sid = 'AC61e828fb385db3a170614caa89f9c7dd'; // Replace with your Twilio SID
$token = '6dc11a47495e9d9b9c48658fd9015aa7'; // Replace with your Twilio token
$twilio_number = '+19293252229'; // Replace with your Twilio number

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to access this page.'); window.location.href='login.php';</script>";
    exit;
}

$current_user = $_SESSION['username']; // Get the logged-in user's username
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search and Request Blood</title>
    <link rel="stylesheet" type="text/css" href="styleS.css">
    <style>
    body {
    font-family: Arial, sans-serif;
    position: relative; /* Required for absolute positioning of buttons */
    background-image: url('images/aaa.jpg'); /* Path to your background image */
    background-size: cover; /* Cover the entire viewport */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    /* Change text color to white for better contrast */
    }
    .back-button {
        display: inline-block;
        padding: 10px;
        margin: 10px 0;
        background-color: #ff0000; /* Primary color */
        color: white;
        text-decoration: none;
        border-radius: 100px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .back-button:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }

    /* New button styles */
    .top-left-buttons {
        position: absolute;
        top: 10px;
        left: 10px;
        display: none; /* Initially hidden */
        z-index: 1000; /* Ensure buttons are above other content */
    }
    .top-left-buttons a {
        display: block;
        margin: 5px 0;
        padding: 10px;
        background-color: #007bff; /* Blue color */
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    .top-left-buttons a:hover {
        background-color: #0056b3; /* Darker shade on hover */
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#blood_type').change(function() {
        var bloodType = $(this).val();
        $.ajax({
          type: 'POST',
          url: 'fetch_cities.php', // Separate PHP file to fetch cities
          data: { blood_type: bloodType },
          success: function(data) {
            $('#city').html(data);
          }
        });
      });

      // Show buttons when mouse is within 50 pixels from the top-left corner
      $(document).mousemove(function(e) {
        if (e.pageX < 50 && e.pageY < 50) {
          $('.top-left-buttons').stop(true, true).slideDown(300);
        } else {
          // Delay the hiding of buttons to allow clicking
          setTimeout(function() {
            if (!$('.top-left-buttons:hover').length) {
              $('.top-left-buttons').stop(true, true).slideUp(300);
            }
          }, 100); // Adjust delay as needed
        }
      });
    });
  </script>
</head>
<body>
    <div class="top-left-buttons">
    <a href="javascript:history.back()" class="back-button">← Back</a>
  
     <a href="home.php" class="back-button">🏠 Home</a>
       <a href="index1.php" class="back-button"> LogOut</a>
  </div>
<div class="container">
    <h1>Search for Blood Donors</h1>
    <form action="" method="post">
        <label for="blood_type">Blood Type:</label>
        <select id="blood_type" name="blood_type" required>
            <option value="">Select Blood Type</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <label for="city">City:</label>
         <select id="city" name="city">
      <option value="" disabled selected>Select a City</option>
      <?php
      // Fetch unique cities from donor_registration table
      $cityQuery = $db->query("SELECT DISTINCT city FROM donor_registration");
      while ($cityRow = $cityQuery->fetch()) {
          echo "<option value=\"" . htmlspecialchars($cityRow['city']) . "\">" . htmlspecialchars($cityRow['city']) . "</option>";
      }
      ?>
    </select><br><br>
        <input type="submit" name='search' value="Search">
    </form>

    <?php
    if (isset($_POST['search'])) {
        $blood_type = $_POST['blood_type'];
        $city = trim($_POST['city']);

        $q = $db->prepare("SELECT donor_id, email, phone FROM donor_registration WHERE blood_type = :blood_type AND city = :city");
        $q->bindValue(':blood_type', $blood_type);
        $q->bindValue(':city', $city);
        $q->execute();
        $count = $q->rowCount();

        if ($count > 0) {
            echo "<h2>Available Blood Donors:</h2>";
            echo "<form action='' method='post'>"; // Form for blood request
            echo "<table>";
            echo "<tr><th>Select</th><th>Name</th><th>Email</th><th>Phone</th></tr>";

            while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td><input type='radio' name='donor_username' value='" . htmlspecialchars($row['donor_id']) . "' required></td>
                        <td>" . htmlspecialchars($row['donor_id']) . "</td>
                        <td>" . htmlspecialchars($row['email']) . "</td>
                        <td>" . htmlspecialchars($row['phone']) . "</td>
                      </tr>";
            }
            echo "</table><br>";
            echo "<h2>Request Blood</h2>";
            echo "<input type='number' name='units' min='1' placeholder='Units' required><br>";
            echo "<input type='text' name='hospital' placeholder='Hospital' required><br>";
            echo "<input type='text' name='reason' placeholder='Reason for Blood Requirement' required><br>";
            // Hidden fields to maintain donor's info
            echo "<input type='hidden' name='blood_type' value='$blood_type'>"; // Maintain blood type
            echo "<input type='hidden' name='city' value='$city'>"; // Maintain city
            echo "<input type='submit' name='request_blood' value='Request Blood'>";
            echo "</form>"; // Close blood request form
        } else {
            echo "<script>alert('No available blood donors found');</script>";
        }
    }

    if (isset($_POST['request_blood'])) {
        $donor_username = $_POST['donor_username'] ?? null; // Use null coalescing to avoid undefined index
        $units = $_POST['units'];
        $hospital = trim($_POST['hospital']);
        $reason = trim($_POST['reason']);

        // Fetch donor details
        $donorQuery = $db->prepare("SELECT donor_id, email, phone, blood_type, city FROM donor_registration WHERE donor_id = :donor_username");
        $donorQuery->bindValue(':donor_username', $donor_username);
        $donorQuery->execute();
        $donor = $donorQuery->fetch(PDO::FETCH_ASSOC);

        if ($donor) {
            // Insert the blood request into the database, including the donor ID (username)
            $requestQuery = $db->prepare("INSERT INTO blood_request(username, email, phone, blood_type, units, hospital, city, reason, donor_id) VALUES(:username, :email, :phone, :blood_type, :units, :hospital, :city, :reason, :donor_id)");
            
            // You may want to add the donor's username as the donor ID. If you have a specific ID column, adjust accordingly.
            $requestQuery->bindValue(':username', $current_user);
            $requestQuery->bindValue(':email', $donor['email']);
            $requestQuery->bindValue(':phone', $donor['phone']); // Use donor's phone number
            $requestQuery->bindValue(':blood_type', $donor['blood_type']);
            $requestQuery->bindValue(':units', $units);
            $requestQuery->bindValue(':hospital', $hospital);
            $requestQuery->bindValue(':city', $donor['city']);
            $requestQuery->bindValue(':reason', $reason);
            $requestQuery->bindValue(':donor_id', $donor['donor_id']); // Assuming donor ID is the username

            if ($requestQuery->execute()) {
                // Send email notification to the donor using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    // Server settings for email
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'guruda7777@gmail.com'; // Your Gmail address
                    $mail->Password = 'tndk jgrm zvrs ftcl'; // Your app password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('guruda7777@gmail.com', 'KARE Blood Bank Team');
                    $mail->addAddress($donor['email'], $donor['donor_id']); // Add recipient

                    // Email Content
                    $mail->isHTML(false);
                    $mail->Subject = "Emergency Blood Donation Request";
                    $mail->Body = "Dear " . $donor['donor_id'] . ",\n\n" .
                                  "A blood request has been made for the following details:\n" .
                                  "Units: $units\n" .
                                  "Hospital: $hospital\n" .
                                  "Reason: $reason\n" .
                                  "Please contact the requester for more details.\n\n" .
                                  "Contact Phone: " . htmlspecialchars($donor['phone']) . "\n" .
                                  "Thank you for your support!";

                    $mail->send();

                    // Send SMS notification to the donor using Twilio
                    $twilio = new Client($sid, $token);
                    $smsBody = "Hello " . $donor['donor_id'] . ",\n\n" .
                               "A blood request has been made for $units units at $hospital.\n" .
                               "Reason: $reason.\n" .
                               "Please check your email for more details.";

                    $twilio->messages->create(
                        $donor['phone'], // Recipient's phone number
                        [
                            'from' => $twilio_number, // Your Twilio phone number
                            'body' => $smsBody
                        ]
                    );

                    echo "<script>alert('Blood request sent successfully and donor notified via email and SMS.');</script>";
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
                    error_log("Email could not be sent. Error: {$mail->ErrorInfo}"); // Log the detailed error
                }
            } else {
                echo "<script>alert('Blood request failed. Please try again.')</script>";
            }
        } else {
            echo "<script>alert('Donor not found.')</script>";
        }
    }
    ?>
</div>
</body>
</html>
