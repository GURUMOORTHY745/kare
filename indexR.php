<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KARE Blood Donor Website</title>
 
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

    /* Make the Donor Registration image visible by default */
    .action-section.default-visible {
      opacity: 1;
      transform: translateY(0);
    }

    .action-section img {
      width: 200px; /* Set width to 100px */
      height: 200px; /* Set height to 100px */
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

    <!-- Action Sections -->
    <h2>Donor Registration</h2>
    <div class="action-section default-visible" onclick="handleDonorRegistration()">
      <img src="images/Donor_Registration.jpg" alt="Donor Registration">
    </div><br><br><br><br>
    
    <h2>Request Blood</h2>
    <div class="action-section" onclick="handleRequestBlood()">
      <img src="images/request_blood1.jpg" alt="Request Blood">
    </div><br><br><br><br>
    
    <h2>Search Blood Donor</h2>
    <div class="action-section" onclick="handleSearchBloodDonors()">
      <img src="images/search_blood1.jpg" alt="Search Blood Donors">
    </div><br><br>

    <div class="buttons">
      <?php
      session_start();
      // Assuming you have a function to check user requests
      if (isset($_SESSION['user_id'])) {
          $userId = $_SESSION['user_id'];
          // Replace this with your actual function to check requests
          $hasRequests = checkUserRequests($userId); // Implement this function

          if ($hasRequests) {
              echo '<button onclick="window.location.href=\'donate.php\'">Donate</button>';
          }
      }
      ?>
    </div>

    <p><b>Welcome to our KARE blood donor website! Please select an option by clicking on an image above.</b></p>

    <footer>
      <p>&copy; KARE Blood Donor Website</p>
    </footer>
  </div>

  <script>
    const sections = document.querySelectorAll('.action-section');
    let lastScrollTop = 0;

    // Function to handle scroll direction
    window.addEventListener('scroll', () => {
      let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      // Check if scrolling down
      if (scrollTop > lastScrollTop) {
        sections.forEach((section, index) => {
          const sectionTop = section.getBoundingClientRect().top;
          if (sectionTop < window.innerHeight) {
            section.classList.add('visible');
          }
        });
      } else {
        // Scrolling up
        sections.forEach((section, index) => {
          const sectionTop = section.getBoundingClientRect().top;
          if (sectionTop > window.innerHeight) {
            section.classList.remove('visible');
          }
        });
      }
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
    });

    // Handle Donor Registration
    function handleDonorRegistration() {
      // Redirect to Donor Registration page (example)
      window.location.href = "donor_registration.php";
    }

    // Handle Request Blood
    function handleRequestBlood() {
      // Redirect to Request Blood page (example)
      window.location.href = "request_blood.php";
    }

    // Handle Search Blood Donors
    function handleSearchBloodDonors() {
      // Redirect to Search Blood Donors page (example)
      window.location.href = "available_blood_donor.php";
    }
  </script>

</body>
</html>
