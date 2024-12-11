<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - KARE Blood Bank Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f7fafc;
        }

body {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
    background-image: url('images/kala.jpg'); /* Background image applied to the entire page */
    background-size: cover; /* Ensure the image covers the entire page */
    background-repeat: no-repeat; /* Prevent repeating the image */
    background-position: center; /* Center the background image */
    color: #fff; /* White text color for contrast */
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7); /* Optional: text shadow for readability */
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100%; /* Ensures body takes up at least 100% height */
}


        header {
            background-color: rgba(211, 47, 47, 0.8);
            padding: 40px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        nav {
            background-color: #b71c1c;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        nav a {
            display: inline-block;
            padding: 16px 24px;
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: #d32f2f;
            color: #f7fafc;
            transform: scale(1.05);
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
            padding: 20px;
            margin-top: 60px;
        }

        .hero h2 {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
            color: #fff;
            text-transform: uppercase;
        }

        .hero p {
            font-size: 1.4rem;
            margin-top: 10px;
            color: #fff;
        }

        .btn {
            display: inline-block;
            background-color: #d32f2f;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #c62828;
            transform: scale(1.1);
        }

        .container {
            max-width: 1200px;
            margin: 60px auto;
            padding: 20px;
            text-align: center;
        }

        .container h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #d32f2f;
            margin-bottom: 30px;
        }

        .container p {
            font-size: 1.2rem;
            line-height: 1.8;
            max-width: 900px;
            margin: 0 auto;
            color: #333;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }

        .card h3 {
            font-size: 1.6rem;
            color: #d32f2f;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1rem;
            color: #555;
        }

        .footer {
            background-color: #d32f2f;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <header>
        <h1>KARE Blood Bank Management</h1>
    </header>

    <nav>
        <a href="home.php">Home</a>
        <a href="index1.php">User Login</a>
        <a href="indexA.php">Admin Login</a>
        <a href="info.php">Donor Info</a>
    </nav>
    <div class="hero">
        <div>
            <h2>Welcome to KARE Blood Bank</h2>
            <p>Helping save lives through blood donations</p>
            <a href="learn.php" class="btn">Learn More</a>
        </div>
    </div>
<br><br><br><br><br><br><br><br>
    <div class="container">
        <h2>Our Mission</h2>
        <p>
            KARE Blood Bank is committed to providing a continuous supply of blood to hospitals and clinics. Our goal is
            to save lives through voluntary donations. Join us in this noble cause and make a difference today!
        </p>
    </div>

    <div class="container">
        <div class="card">
            <h3>Why Donate Blood?</h3>
            <p>Your blood donation can help save up to 3 lives. Every pint of blood donated can help patients in need of
                surgeries, cancer treatments, trauma care, and more.</p>
        </div>
        <div class="card">
            <h3>How to Donate</h3>
            <p>Donating blood is simple and only takes about 30 minutes. You can donate at our blood donation camps or
                partner hospitals. No prior appointment needed.</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 KARE Blood Bank | <a href="privacy.html">Privacy Policy</a></p>
    </div>

</body>

</html>
