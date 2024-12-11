<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KARE Blood Donor Website</title>
  
  <!-- Include Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: url('images/index.jpg') no-repeat center center fixed;
      background-size: cover; 
      color: black; 
    }

    .container {
      width: 60%;
      margin: 0 auto;
      text-align: center;
      padding: 20px; 
    }

    h1 {
      margin: 20px 0;
      font-size: 2em;
      color: black; 
    }

    .action-section {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.5s ease, transform 0.5s ease;
      margin: 30px 0;
    }

    .action-section.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .action-section img {
      width: 200px; /* Set width to 200px */
      height: 200px; /* Set height to 200px */
      object-fit: cover; /* Maintain aspect ratio */
      border-radius: 5px; /* Optional: Add rounded corners */
      margin-bottom: 10px; /* Space between image and title */
      cursor: pointer; /* Change cursor to pointer on hover */
    }

    footer {
      margin-top: 20px;
      padding: 3px;
      background-color: #333;
      color: white;
    }

    /* Notification icon styles */
    .notification-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      font-size: 24px;
      color: black; /* Change color as needed */
      display: none; /* Hidden by default */
      cursor: pointer; /* Change cursor to pointer on hover */
    }

    .badge {
      position: absolute;
      top: -5px;
      right: -10px;
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
      display: none; /* Hidden by default */
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 1.5em;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Welcome to KARE Blood Donor Website <span>🩸</span></h1><br><br>
    
    <h2>Donor Registration</h2>
    <div class="action-section">
      <img src="images/Donor_Registration.jpg" alt="Donor Registration" onclick="handleDonorRegistration()">
    </div><br><br>

    <h2>Manage Requests</h2>
    <div class="action-section">
      <img src="images/manage_requests1.jpg" alt="Manage Requests" onclick="handleManageRequests()">
    </div><br><br>

    <h2>Request Blood</h2>
    <div class="action-section">
      <img src="images/request_blood1.jpg" alt="Request Blood" onclick="handleRequestBlood()">
    </div><br><br>

    <h2>Search Blood Donors</h2>
    <div class="action-section">
      <img src="images/search_blood1.jpg" alt="Search Blood Donors" onclick="handleSearchBloodDonors()">
    </div><br>

    <footer>
      <p>&copy; KARE Blood Donor Website</p>
    </footer>
  </div>

  <!-- Notification Icon with Badge -->
  <div class="notification-icon" id="notificationIcon" onclick="handleManageRequests()">
    <i class="fas fa-bell"></i>
    <span class="badge" id="notificationBadge">0</span>
  </div>

  <script>
    // Function to handle section visibility on scroll
    const sections = document.querySelectorAll('.action-section');

    const options = {
      root: null,
      threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        } else {
          entry.target.classList.remove('visible');
        }
      });
    }, options);

    sections.forEach(section => {
      observer.observe(section);
    });

    // Action handlers for each section
    function handleDonorRegistration() {
      window.location.href = 'donor_registration.php';
    }

    function handleManageRequests() {
      window.location.href = 'manage_requests.php';
    }

    function handleRequestBlood() {
      window.location.href = 'request_blood.php';
    }

    function handleSearchBloodDonors() {
      window.location.href = 'available_blood_donor.php';
    }

    // Function to check for pending requests and show notification icon
    function checkPendingRequests() {
      // Fetch the pending request count from the server
      fetch('check_pending_requests.php')  // Path to the PHP script
        .then(response => response.json())   // Parse the response as JSON
        .then(data => {
          const pendingRequestsCount = data.pendingRequestsCount; // Get the count from the response

          if (pendingRequestsCount > 0) {
            document.getElementById('notificationIcon').style.display = 'block'; // Show icon
            document.getElementById('notificationBadge').textContent = pendingRequestsCount; // Set badge text
            document.getElementById('notificationBadge').style.display = 'inline'; // Show badge
          } else {
            document.getElementById('notificationIcon').style.display = 'none'; // Hide icon
            document.getElementById('notificationBadge').style.display = 'none'; // Hide badge
          }
        })
        .catch(error => {
          console.error('Error fetching pending requests:', error);
        });
    }

    // Call the function to check for pending requests on page load
    window.onload = checkPendingRequests;
  </script>

</body>
</html>
