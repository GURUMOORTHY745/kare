<?php
// Database connection parameters
$host = "localhost";  // your database host
$user = "root";       // your database username
$password = "";       // your database password
$dbname = "Blood_Bank_KARE"; // your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the count of pending requests
$sql = "SELECT COUNT(*) AS pending_count FROM blood_request WHERE status = 'pending'";
$result = $conn->query($sql);

// Fetch the result and get the pending count
$pendingRequestsCount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pendingRequestsCount = $row['pending_count'];
}

// Close the connection
$conn->close();

// Return the count as JSON
echo json_encode(['pendingRequestsCount' => $pendingRequestsCount]);
?>
