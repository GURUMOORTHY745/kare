<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=your_database_name', 'your_username', 'your_password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
