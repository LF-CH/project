<?php
session_start();
require_once '../database/connect.php';

if (!isset($_SESSION['retailer_id'])) {
    header("location: retailer.php");
    exit;
}

$retailer_id = $_SESSION['retailer_id'];


$sql = "SELECT * FROM bookings WHERE ret_name = (SELECT ret_name FROM retailer WHERE retailer_id = '$retailer_id')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Management</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Booking Management</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link active'>Manage Bookings</a>
        <a href='dashboard.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <?php if (!empty($message)): ?>
        <p class='update-message'><?php echo $message; ?></p>
    <?php endif; ?>

    <div class='content'>
        <table class='data-table'>
            <tr><th>Customer ID</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['collection_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['collection_time']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td>
                        <form method='POST' class='status-form'>
                            <input type='hidden' name='booking_id' value='<?php echo $row['bookings_id']; ?>'>
                            <select name='status' class='status-select'>
                                <option value='Pending' <?php echo ($row['status'] == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value='Accepted' <?php echo ($row['status'] == 'Accepted' ? 'selected' : ''); ?>>Accept</option>
                                <option value='Rejected' <?php echo ($row['status'] == 'Rejected' ? 'selected' : ''); ?>>Reject</option>
                            </select>
                            <input type='submit' value='Update' class='update-button'>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
