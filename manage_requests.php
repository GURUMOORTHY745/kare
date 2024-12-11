<?php
session_start();
require 'connect.php'; // Database connection

// Check if the user is logged in
if (!isset($_SESSION['username'])) { // Assuming username is stored in session
    header('Location: login.php'); // Redirect to login if not authenticated
    exit;
}

$donor_id = $_SESSION['username']; // Get the donor ID from the session

// Debugging line


// Fetch requests for the logged-in user using donor_id
$query = $db->prepare("SELECT * FROM blood_request WHERE donor_id = :donor_id");
$query->bindParam(':donor_id', $donor_id, PDO::PARAM_STR);

try {
    $query->execute();
    $requests = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}

// Check if requests are found
if (empty($requests)) {
    echo 'No requests found for this user.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Requests</title>
    <link rel="stylesheet" type="text/css" href="style.css">
      <style>
    body {
        font-family: Arial, sans-serif;
        position: relative; /* Required for absolute positioning of buttons */
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
    <style>
        body {
    font-family: Arial, sans-serif;
    position: relative; /* Required for absolute positioning of buttons */
    background-image: url('images/aaa.jpg'); /* Path to your background image */
    background-size: cover; /* Cover the entire viewport */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    
    }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            padding: 5px 10px;
            margin: 5px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        button[name="action"][value="accept"] {
            background-color: #4CAF50;
            color: white;
        }
        button[name="action"][value="reject"] {
            background-color: #f44336;
            color: white;
        }
        button:hover {
            opacity: 0.8;
        }
        .back-button {
            display: inline-block;
            padding: 9px 10px;
            margin: 15px 0;
            background-color:   #ff0000; /* Primary color */
            color: white;
            text-decoration: none;
            border-radius: 100px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="top-left-buttons">
    <a href="javascript:history.back()" class="back-button">← Back</a>
    <a href="home.php" class="back-button">🏠 Homes</a>
        <a href="index1.php" class="back-button"> LogOut</a>

  </div>
    <h1>Your Blood Requests</h1>
    
    <?php if (isset($_SESSION['status_message'])): ?>
        <p>Status: <?php echo htmlspecialchars($_SESSION['status_message']); ?></p>
        <?php unset($_SESSION['status_message']); // Clear the message after displaying ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>Username</th> <!-- Added Username column -->
            <th>Phone</th>
            <th>Blood Type</th>
            <th>Units</th>
            <th>Hospital</th>
            <th>City</th>
            <th>Reason</th>
            <th>Donor ID</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['username']); ?></td> <!-- Display Username -->
               <td><?php echo htmlspecialchars($request['phone']); ?></td>
                <td><?php echo htmlspecialchars($request['blood_type']); ?></td>
                <td><?php echo htmlspecialchars($request['units']); ?></td>
                <td><?php echo htmlspecialchars($request['hospital']); ?></td>
                <td><?php echo htmlspecialchars($request['city']); ?></td>
                <td><?php echo htmlspecialchars($request['reason']); ?></td>
                 <td><?php echo htmlspecialchars($request['donor_id']); ?></td>
                <td><?php echo isset($request['status']) ? htmlspecialchars($request['status']) : 'N/A'; ?></td>
                <td>
                    <?php if (isset($request['status']) && $request['status'] === 'pending'): ?>
                        <form method="POST" action="process_request.php">
                            <input type="hidden" name="donor_id" value="<?php echo htmlspecialchars($donor_id); ?>">
                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                            <button type="submit" name="action" value="accept">Accept</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    <?php else: ?>
                        <span>Action Completed</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
