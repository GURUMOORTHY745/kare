<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Information - KARE Blood Bank Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Light grey background */
            background-image: url('images/aaa.jpg'); /* Replace with a real background image */
            background-size: cover;
            background-position: center;
        }
        header {
            background-color: white;
            color: black;
            padding: 10px 0;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2em; /* Increase font size */
            font-weight: 700; /* Make it bold */
        }
        nav {
            background-color: #b71c1c;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #d32f2f;
        }
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }
        .feature-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 30%;
            margin: 10px 0;
            text-align: center;
            transition: transform 0.2s;
            border: 2px solid #d32f2f; /* Red border around each donor box */
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }
        .feature-box img {
            max-width: 100px; /* Smaller image size */
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .feature-box h3 {
            margin-top: 10px;
            font-size: 1.1em;
            font: bold;
            color: #333;
        }
        .feature-box p {
            color: #555;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; /* Make table background solid white */
            border: 2px solid #d32f2f; /* Red border for the table */
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            color: black; /* Change text color to black */
        }
        th {
            background-color: #d32f2f;
            color: white; /* Set header text color to white */
        }
        @media (max-width: 768px) {
            .feature-box {
                width: 100%; /* Full width on smaller screens */
            }
        }
    </style>
</head>
<body>
<header>
    <h1>KARE Blood Bank Management</h1>
</header>
<nav>
    <a href="home.php">Home</a>
    <a href="index1.php">User  Login</a>
    <a href="indexA.php">Admin Login</a>
    <a href="info.php">Donor Info</a>
</nav>
<div class="container">
    <div class="features">
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Blood_Bank_KARE";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("<p>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
        }

        // Fetch donor information using prepared statement
        $stmt = $conn->prepare("SELECT donor_id, blood_type, email, city, phone FROM donor_registration");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo '<div class="feature-box">';
                    echo '<h3>Donor ID: ' . htmlspecialchars($row["donor_id"]) . '</h3>';
                    echo '<p>Blood Group: ' . htmlspecialchars($row["blood_type"]) . '</p>';
                    echo '</div>';
                }
            } else {
                echo "<p>No donor information available.</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
        }

        // Fetch blood group counts
        $groupStmt = $conn->prepare("SELECT blood_type, COUNT(*) as count FROM donor_registration GROUP BY blood_type");
        if ($groupStmt) {
            $groupStmt->execute();
            $groupResult = $groupStmt->get_result();

            echo '<table>';
            echo '<tr><th>Blood Group</th><th>Number of Donors</th></tr>';
            if ($groupResult->num_rows > 0) {
                while($groupRow = $groupResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($groupRow["blood_type"]) . '</td>';
                    echo '<td>' . htmlspecialchars($groupRow["count"]) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2">No data available</td></tr>';
            }
            echo '</table>';
            $groupStmt->close();
        } else {
            echo "<p>Error preparing statement: " . htmlspecialchars($conn->error) . "</p>";
        }

        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
