<?php
// login.php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Include database connection file
include 'connectA.php'; // This should include your correct database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username and password from POST
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a prepared statement to check if the username exists in the database
    $stmt = $conn->prepare("SELECT * FROM Admin WHERE username = ?");
    $stmt->bind_param("s", $username); // "s" indicates the parameter is a string

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the result contains a row
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Directly compare the password from the database and the user input
        if ($password === $row['password']) {
            // Password is correct, set session variable and redirect to admin dashboard
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $username; // Store username in session (optional)

            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Invalid password.";
        }
    } else {
        // Username does not exist
        $error_message = "Invalid username.";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection after use
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARE Blood Bank Management System - Admin Login</title>
    <link rel="stylesheet" href="animation1.css">
</head>
<body>

    <!-- Login Form Container -->
    <div class="login-container">
        <h2>Admin Login</h2>

        <!-- Display error message if login fails -->
        <?php if (isset($error_message)) { echo '<p style="color: red;">' . $error_message . '</p>'; } ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
