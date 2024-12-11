<?php
session_start();
require 'connect.php'; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: index1.php'); // Redirect to login if not logged in
    exit;
}

// Fetch blood requests from the database
$query = $db->prepare("SELECT br.id, br.blood_type, br.units, br.hospital, br.city, br.reason, br.status ,br.donor_id,
                       FROM blood_request br");
$query->execute();
$requests = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Requests</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f2f2f2; }
        button { padding: 5px 10px; margin: 2px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Blood Requests</h1>
    <?php if (empty($requests)): ?>
        <p>No requests found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Blood Type</th>
                <th>Units</th>
                <th>Hospital</th>
                <th>City</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($requests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['blood_type']); ?></td>
                <td><?php echo htmlspecialchars($request['units']); ?></td>
                <td><?php echo htmlspecialchars($request['hospital']); ?></td>
                <td><?php echo htmlspecialchars($request['city']); ?></td>
                <td><?php echo htmlspecialchars($request['reason']); ?></td>
                <td><?php echo htmlspecialchars($request['status']); ?></td>
                <td>
                    <form method="post" action="process_request.php" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                        <button type="submit" name="action" value="accept">Accept</button>
                    </form>
                    <form method="post" action="process_request.php" style="display:inline;">
                        <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                        <button type="submit" name="action" value="reject">Reject</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>