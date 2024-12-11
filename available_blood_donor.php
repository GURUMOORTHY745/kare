<?php
include('connect.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search Blood</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    body {
    font-family: Arial, sans-serif;
    position: relative; /* Required for absolute positioning of buttons */
    background-image: url('images/aaa.jpg'); /* Path to your background image */
    background-size: cover; /* Cover the entire viewport */
    background-position: center; /* Center the background image */
    background-repeat: no-repeat; /* Prevent the image from repeating */
    
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
</head>
<body>
  <div class="top-left-buttons">
    <a href="javascript:history.back()" class="back-button">← Back</a>
    <a href="home.php" class="back-button">🏠Home</a>
        <a href="index1.php" class="back-button"> LogOut</a>

  </div>
  
  <h1>Search Blood</h1>
  <form action="" method="post">
    <label for="blood_type">Blood Type:</label>
    <select id="blood_type" name="blood_type">
      <option value="all">All Blood Types</option>
      <option value="A+">A+</option>
      <option value="A-">A-</option>
      <option value="B+">B+</option>
      <option value="B-">B-</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
    </select><br><br>

 <label for="city">City:</label>
    <select id="city" name="city">
      <option value="all">All Cities</option>
      <?php
      // Fetch unique cities from donor_registration table
      $cityQuery = $db->query("SELECT DISTINCT city FROM donor_registration");
      while ($cityRow = $cityQuery->fetch()) {
          echo "<option value=\"" . htmlspecialchars($cityRow['city']) . "\">" . htmlspecialchars($cityRow['city']) . "</option>";
      }
      ?>
    </select><br><br>
    <input type="submit" name='sub' value="Search">
  </form>

<?php
if(isset($_POST['sub']))
{
    $blood_type = $_POST['blood_type'];
    $city = $_POST['city'];

    // Modify SQL query based on selected options
    $query = "SELECT * FROM donor_registration WHERE 1";
    
    if ($blood_type != 'all') {
        $query .= " AND blood_type = :blood_type";
    }
    
    if ($city != 'all') {
        $query .= " AND city = :city";
    }

    // Prepare and execute the query
    $q = $db->prepare($query);

    if ($blood_type != 'all') {
        $q->bindValue('blood_type', $blood_type);
    }

    if ($city != 'all') {
        $q->bindValue('city', $city);
    }

    $q->execute();
    $count = $q->rowCount();
    
    if($count > 0) {
        echo "<h2>Available Blood Donors:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Serial No.</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Blood Type</th></tr>";

        // Initialize serial number counter
        $serialNo = 1;
        
        while($row = $q->fetch())
 {
            echo "<tr><td>" . $serialNo++ . "</td><td>" . htmlspecialchars($row['donor_id']) . "</td><td>" . htmlspecialchars($row['email']) . "</td><td>" . htmlspecialchars($row['phone']) . "</td><td>" . htmlspecialchars($row['city']) . "</td><td>" . htmlspecialchars($row['blood_type']) . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<script>alert('No available blood donors found')</script>";
    }
}
?>
</body>
</html>