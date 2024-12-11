<?php
include('connect.php');
session_start();

if (isset($_POST['change_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $email = $_SESSION['email'];

        // Update the user's password in the database
        $q = $db->prepare("UPDATE user SET password = :password WHERE email = :email");
        $q->bindValue(':password', $new_password); // Store password as plain text (consider hashing)
        $q->bindValue(':email', $email);

        if ($q->execute()) {
            echo "<script>alert('Password changed successfully!')</script>";
            unset($_SESSION['otp'], $_SESSION['email']); // Clear the session variables
            header('Location: index1.php'); // Redirect to login page
            exit();
        } else {
            echo "<script>alert('Failed to change password. Please try again.')</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match.')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="styleC.css">
</head>
<body>
    <h2>Change Password</h2>
    <form method="post" action="">
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" name="change_password" value="Change Password">
    </form>
</body>
</html>
