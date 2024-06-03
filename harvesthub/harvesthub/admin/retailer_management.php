<?php

require_once '../database/connect.php';

$sql = "SELECT * FROM retailer";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Retailer Management</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h2 class='dashboard-title'>Retailer Management</h2>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='control.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <a href='add_ret.php' class='add-button'>Add Retailer</a>

    <div class='content'>
        <table>
            <tr>
                <th>Retailer Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ret_name'] . "</td>";
                echo "<td>" . $row['location'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['image'] . "</td>";
                echo "<td><a href='edit_ret.php?retailer_id=" . $row['retailer_id'] . "'>Edit</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
