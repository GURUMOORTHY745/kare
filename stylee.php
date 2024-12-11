body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    background-image: url('https://www.sriramakrishnahospital.com/wp-content/uploads/2021/06/Blood-Donation-1.jpg');
    background-size: cover;
    background-attachment: fixed;
}

#full {
    width: 100%;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

#inner_full {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    text-align: center;
}

#header {
    margin-bottom: 20px;
}

h1 {
    color: #a50000; /* Blood red color */
}

h3 {
    color: #333;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"],
button {
    background-color: #a50000; /* Blood red color */
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover,
button:hover {
    background-color: #c70000; /* Darker red on hover */
}

#footer {
    margin-top: 20px;
    font-size: 12px;
    color: #666;
}
