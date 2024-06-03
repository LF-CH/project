<?php
session_start();
require_once '../database/connect.php';

if (!isset($_SESSION['retailer_id'])) {
    header("Location: retailer_auth.php");
    exit;
}

$search = mysqli_real_escape_string($conn, $_GET['search_value']);

$sql = "SELECT * FROM foods WHERE food_name LIKE '%$search%' OR description LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Food Items</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Search Results for Food Items</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link'>Manage Bookings</a>
        <a href='dashboard.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <table>
            <tr><th>Food Name</th><th>Description</th><th>Price</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['food_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
