<?php
session_start();
require_once '../database/connect.php';

if (!isset($_SESSION['retailer_id'])) {
    header("Location: retailer_auth.php");
    exit;
}

$searchDate = mysqli_real_escape_string($conn, $_GET['search_date']);

$sql = "SELECT * FROM bookings WHERE collection_date = '$searchDate'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Bookings</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Search Results for Bookings</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link'>Manage Bookings</a>
        <a href='dashboard.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <table>
            <tr><th>User ID</th><th>Collection Date</th><th>Status</th><th>Total Amount</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['collection_date']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['total_amount']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
