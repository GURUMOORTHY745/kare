<?php
// Start session to verify login status
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Include your database connection file here (make sure this file uses PDO for DB connection)
require_once 'connect.php'; // Make sure this file uses PDO for DB connection

// Default values for pagination
$limit = 10; // Number of donors per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Initialize pagination variables
$total_donors = 0;
$total_pages = 1; // Default to 1 to avoid division by zero

// Count total donors for pagination
try {
    $total_result = $db->query("SELECT COUNT(*) AS total FROM donors");
    $total_row = $total_result->fetch(PDO::FETCH_ASSOC);
    $total_donors = $total_row['total'];
    $total_pages = ceil($total_donors / $limit);
} catch (PDOException $e) {
    // Handle the error appropriately (e.g., log it, display a message, etc.)
    echo "Error fetching total donors: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KARE Blood Bank Management System</title>
    <style>
        /* Include your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .dashboard-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            color: #d9534f; /* Blood red color */
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .dashboard-links {
            display: flex;
            flex-direction: column;
            gap: 10px; /* Space between buttons */
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #d9534f; /* Blood red color */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #c9302c; /* Darker red on hover */
        }

        .logout-btn {
            background-color: #5bc0de; /* Light blue for logout */
        }

        .logout-btn:hover {
            background-color: #31b0d5; /* Darker blue on hover */
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination .btn {
            margin-right: 5px; /* Space between pagination buttons */
        }

        .pagination .btn:hover {
            background-color: #c9302c; /* Darker red for pagination hover */
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin! You are logged in.</p>

        <div class="dashboard-links">
            <a href="add_donor.php" class="btn">Add Donor</a>
            <a href="edit.php" class="btn">Edit DB</a>
            
            <a href="home.php" class="btn logout-btn">Logout</a>
        </div>

         <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="btn">Previous</a>
            <?php endif; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="btn">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
