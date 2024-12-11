<?php
// Database connection settings
$servername = "localhost";  // Typically 'localhost' for local development
$username = "root";         // Default MySQL username (can be different for your setup)
$password = "";             // Default MySQL password (usually empty in XAMPP/WAMP setup)
$dbname = "blood_bank_kare"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
