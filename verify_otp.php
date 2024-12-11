<?php
session_start();

if (isset($_POST['verify_otp'])) {
    $input_otp = $_POST['otp'];

    if ($input_otp == $_SESSION['otp']) {
        // OTP is valid, redirect to change password page
        header('Location: change_password.php');
        exit();
    } else {
        echo "<script>alert('Invalid OTP. Please try again.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Verify OTP</h2>
    <form method="post" action="">
        <input type="text" name="otp" placeholder="Enter your OTP" required>
        <input type="submit" name="verify_otp" value="Verify">
    </form>
</body>
</html>
