<?php
include('connect.php');
session_start();
require 'vendor/autoload.php'; // Ensure PHPMailer is loaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Check if username or email already exists
    $q = $db->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
    $q->bindValue(':username', $username);
    $q->bindValue(':email', $email);
    $q->execute();

    if ($q->rowCount() > 0) {
        echo "<script>alert('Username or email already exists')</script>";
    } else {
        // Check if passwords match
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match')</script>";
        } else {
            // Insert user into the user table without hashing the password
            $q = $db->prepare("INSERT INTO user (username, password, email) VALUES (:username, :password, :email)");
            $q->bindValue(':username', $username);
            $q->bindValue(':password', $password); // Store password as plain text
            $q->bindValue(':email', $email);
            
            if ($q->execute()) {
                // Send confirmation email
                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'guruda7777@gmail.com'; // Your Gmail address
                    $mail->Password = 'tndk jgrm zvrs ftcl'; // Your app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use TLS
                    $mail->Port = 587;

                    // Recipients
                    $mail->setFrom('guruda7777@gmail.com', 'KARE Blood Bank');
                    $mail->addAddress($email); // Send to the user's email

                    // Content
                    $mail->isHTML(false);
                    $mail->Subject = "Welcome to KARE Blood Bank";
                    $mail->Body = "Dear $username,\n\nThank you for signing up for the KARE Blood Bank Management System.\n\nWe are glad to have you on board!\n\nBest Regards,\nKARE Blood Bank Team";

                    $mail->SMTPDebug = 2; // Set to 0 for no debug output, 1 for client messages, 2 for client and server messages


                    $mail->send();

                    // Redirect to login page on success
                    header('Location: index1.php');
                    exit();
                } catch (Exception $e) {
                    echo "<script>alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
                }
            } else {
                echo "<script>alert('Signup failed. Please try again.')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="stylle.css">
    <link rel="stylesheet" type="text/css" href="animations.css"> 
</head>
<body>
    <div id="full">
        <div id="inner_full">
            <div id="header"><h1>KARE Blood Bank Management System</h1></div>
            <div id="body">
                <form action="" method="post">
                    <table align="left">
                        <tr>
                            <td width="150px" height="70px"><h3>Enter Username</h3></td>
                            <td width="100px" height="70px"><input type="text" name="username" placeholder="Enter Username" required style="width: 180px;height:30px;border-radius: 15px;"></td>
                        </tr>
                        <tr>
                            <td width="150px" height="70px"><h3>Enter Email</h3></td>
                            <td width="200px" height="70px"><input type="email" name="email" placeholder="Enter Email" required style="width: 180px;height:30px;border-radius: 15px;"></td>
                        </tr>
                        <tr>
                            <td width="150px" height="70px"><h3>Enter Password</h3></td>
                            <td width="200px" height="70px"><input type="password" name="password" placeholder="Enter Password" required style="width: 180px;height:30px;border-radius: 15px;"></td>
                        </tr>
                        <tr>
                            <td width="150px" height="70px"><h3>Confirm Password</h3></td>
                            <td width="200px" height="70px"><input type="password" name="confirm_password" placeholder="Confirm Password" required style="width: 180px;height:30px;border-radius: 15px;"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="signup" value="Sign Up" style="width: 70px;height:30px;border-radius: 5px;"></td>
                        </tr>
                    </table>
                </form>
                <br>
                <h3>Already have an account?</h3>
                <a href="index1.php"><button style="width: 100px; height: 30px; border-radius: 5px;">Login</button></a>
            </div>
        </div>
    </div>
</body>
</html>
