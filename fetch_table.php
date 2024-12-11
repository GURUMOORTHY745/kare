<?php
// fetch_table.php

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

// Step 1: Get the table name from the request
$table_name = isset($_GET['table']) ? $_GET['table'] : '';

// Step 2: Handle form submission and update database if data is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tables'])) {
    $tables_data = $_POST['tables'];

    // Loop through the posted data and update the database
    foreach ($tables_data as $table => $rows) {
        if ($table === $table_name) {
            foreach ($rows as $id => $columns) {
                $update_values = [];
                foreach ($columns as $column => $value) {
                    // Prepare the updated values
                    $update_values[] = "`$column` = '" . $conn->real_escape_string($value) . "'";
                }

                // Join the updated values into an SQL string
                $update_query = "UPDATE `$table_name` SET " . implode(", ", $update_values) . " WHERE `$primary_key` = '$id'";

                // Execute the update query
                if ($conn->query($update_query) === TRUE) {
                    echo "<p>Record with ID $id has been updated successfully.</p>";
                } else {
                    echo "<p>Error updating record: " . $conn->error . "</p>";
                }
            }
        }
    }
}

// Step 3: Fetch the data for the specified table
if (!empty($table_name)) {
    $data_query = "SELECT * FROM `$table_name`";
    $data_result = $conn->query($data_query);

    if ($data_result->num_rows > 0) {
        // Get the column names
        $columns = $data_result->fetch_fields();
        $column_names = [];
        $primary_key = null;

        // Find the primary key or the unique identifier column
        foreach ($columns as $column) {
            $column_names[] = $column->name;
            if ($column->flags & MYSQLI_PRI_KEY_FLAG) {
                $primary_key = $column->name; // Store the primary key column name
            }
        }

        // If no primary key column is found, use the first column as an ID
        if (!$primary_key && count($column_names) > 0) {
            $primary_key = $column_names[0];
        }

        // Reorder columns: Ensure the 'id' column (or primary key) is at the top
        if ($primary_key) {
            // Move the primary key to the top of the column list
            $column_names = array_diff($column_names, [$primary_key]);
            array_unshift($column_names, $primary_key);  // Move the primary key to the first position
        }

        // Display table headers with columns in correct order
        echo "<form method='POST'>";  // Wrap in a form to handle save actions
        echo "<table><tr>";
        
        // Display column headers
        foreach ($column_names as $column_name) {
            echo "<th>$column_name</th>";
        }
        echo "<th>Actions</th></tr>";

        // Display each row of the table
        while ($row = $data_result->fetch_assoc()) {
            echo "<tr>";
            $row_id = $row[$primary_key];  // Use the primary key as the row ID

            // Display the primary key value in the table
            echo "<td>$row_id</td>";  // Display primary key value in the first column

            // Display the rest of the columns (excluding the primary key column)
            foreach ($column_names as $column_name) {
                if ($column_name != $primary_key) {
                    $value = htmlspecialchars($row[$column_name]);  // Handle special chars
                    echo "<td><input type='text' name='tables[$table_name][$row_id][$column_name]' value='$value' /></td>";
                }
            }

            // Action buttons (submit/save changes)
            echo "<td><input type='submit' value='Save Changes'></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "<div class='no-data'>No data available in this table.</div>";
    }
}

$conn->close();
?>
