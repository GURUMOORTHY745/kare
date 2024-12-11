<?php
// Step 1: Database connection
$servername = "localhost"; // your server
$username = "root"; // your username
$password = ""; // your password
$dbname = "blood_bank_kare"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch all tables in the database
$tables_query = "SHOW TABLES";
$tables_result = $conn->query($tables_query);

if (!$tables_result) {
    die("Error fetching tables: " . $conn->error);
}

// Step 3: Handle the form submission for editing data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['tables'] as $table => $rows) {
        foreach ($rows as $row_id => $data) {
            foreach ($data as $field => $value) {
                // Step 4: Prepare the UPDATE statement for each field in each row
                $value = $conn->real_escape_string($value);
                $update_query = "UPDATE `$table` SET `$field` = '$value' WHERE id = $row_id";
                if (!$conn->query($update_query)) {
                    echo "Error updating record: " . $conn->error;
                }
            }
        }
    }
}

// Step 5: Render the tables and allow editing of the data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Database Records</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .table-container {
            margin-bottom: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .table-container h2 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .table-container h2:hover {
            background-color: #0056b3;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-container th, .table-container td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-container th {
            background-color: #f1f1f1;
        }
        .table-container td {
            background-color: #fff;
        }
        .table-container input[type="text"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .table-container input[type="submit"] {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .table-container input[type="submit"]:hover {
            background-color: #218838;
        }
        .table-container .no-data {
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

    <h1>Edit Database Records</h1>

    <div class="container">
        <form method="POST">
            <?php
            // Fetch all tables and render clickable names
            while ($table = $tables_result->fetch_array()) {
                $table_name = $table[0];
                echo "<div class='table-container'>";
                echo "<h2 onclick='loadTableData(\"$table_name\")'>$table_name</h2>";
                echo "<div id='table_$table_name' style='display:none;'></div>";
                echo "</div>";
            }
            ?>
        </form>
    </div>

    <script>
        // JavaScript function to load table data via AJAX
        function loadTableData(tableName) {
            var tableDiv = document.getElementById('table_' + tableName);
            if (tableDiv.style.display === 'none') {
                tableDiv.style.display = 'block';
            } else {
                tableDiv.style.display = 'none';
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_table.php?table=" + tableName, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    tableDiv.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

</body>
</html>

<?php
// Step 6: Close the database connection
$conn->close();
?>
