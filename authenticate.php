<?php
// Connect to the database
require_once 'connect.php';

// Retrieve the user input
$username = $_POST['un'];
$password = $_POST['ps'];

// Query the database to retrieve the user credentials
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($con, $query);

// Check if the user credentials are valid
if (mysqli_num_rows($result) > 0) {
  // User authenticated, redirect to dashboard or other page
  header('Location: dashboard.php');
  exit;
} else {
  // User not authenticated, display error message
  echo 'Invalid username or password';
}
?>