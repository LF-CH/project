<?php
session_start();
require_once '../database/connect.php';

if (!isset($_SESSION['retailer_id'])) {
    header("location: retailer.php");
    exit;
}

$retailer_id = $_SESSION['retailer_id'];

$sql = "SELECT * FROM foods WHERE ret_name = (SELECT ret_name FROM retailer WHERE retailer_id = '$retailer_id')";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Food Item Management</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Food Item Management</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link active'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link'>Manage Bookings</a>
        <a href='dashboard.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <a href='add_food_item.php' class='add-new'>Add New Food Item</a>
        <table class='data-table'>
            <tr><th>Name</th><th>Description</th><th>Price</th><th>Actions</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                    <td>
                        <a href='edit_food_item.php?id=<?php echo $row['food_id']; ?>' class='edit-link'>Edit</a> |
                        <a href='process_food_item.php?action=delete&id=<?php echo $row['food_id']; ?>' class='delete-link'>Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
