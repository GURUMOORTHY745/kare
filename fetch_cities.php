<?php
include('connect.php');

if (isset($_POST['blood_type'])) {
    $blood_type = $_POST['blood_type'];
    $query = "SELECT DISTINCT city FROM donor_registration WHERE blood_type = :blood_type";
    $stmt = $db->prepare($query);
    $stmt->bindValue('blood_type', $blood_type);
    $stmt->execute();

    $cities = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($cities as $city) {
        echo "<option value=\"" . htmlspecialchars($city) . "\">" . htmlspecialchars($city) . "</option>";
    }
}
?>