<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn More - Blood Donation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7fafc;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #d32f2f;
            padding: 20px 0;
            text-align: center;
            color: white;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .container h2 {
            font-size: 2.5rem;
            color: #d32f2f;
            margin-bottom: 20px;
        }

        .content {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 40px;
        }

        .images {
            display: flex;
            justify-content: center;
            
            gap: 20px;
            flex-wrap: wrap;
        }

        .images img {
            width: 300px;        /* Set width */
            height: 300px;       /* Set height to the same value for a square */
            object-fit: cover;   /* Ensures the image covers the square without stretching */
            border-radius: 8px;  /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  /* Add shadow for effect */
        }

        .footer {
            background-color: #d32f2f;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .footer a {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <header>
        <h1>Learn More About Blood Donation</h1>
    </header>

    <div class="container">
        <h2>What is Blood Donation?</h2>
        <div class="content">
            <p>Blood donation is the process of giving blood to a blood bank or medical facility, where it can be used to save the lives of patients in need. A single donation can help up to three people. There are many situations where blood is required, such as during surgeries, trauma accidents, childbirth, or cancer treatments.</p>
            <p>Voluntary donation of blood plays a crucial role in saving lives. Donors give their blood without any payment, simply to help those in need. The process is safe and has very few risks, with each donation taking only around 30 minutes to complete.</p>
        </div>

        <h2>Why is Blood Donation Important?</h2>
        <div class="content">
            <p>Blood donation is vital because blood cannot be manufactured or synthesized. Hospitals depend on the generosity of individuals who donate blood to ensure that they have enough supplies for emergencies, surgeries, and regular treatments. Additionally, certain medical conditions such as anemia or sickle cell disease require regular blood transfusions, which are only possible through blood donations.</p>
        </div>

        <h2>What Happens After You Donate Blood?</h2>
        <div class="content">
            <p>Once you donate blood, it is carefully tested, typed, and separated into its individual components (red blood cells, platelets, plasma). These components can then be used to treat patients with different medical conditions. The blood you donate will save lives, and your donation helps create a steady supply of life-saving blood for those in need.</p>
        </div>

        <h2>Images of Blood Donation</h2>
        <div class="images">
            <img src="images/blood-donation-1.jpg" alt="Blood Donation 1">
            <img src="images/blood-donation-2.jpg" alt="Blood Donation 2">
            <img src="images/blood-donation-3.jpg" alt="Blood Donation 3">
        </div>

    </div>

    <div class="footer">
        <p>&copy; 2024 KARE Blood Bank | <a href="privacy.html">Privacy Policy</a></p>
    </div>

</body>

</html>
