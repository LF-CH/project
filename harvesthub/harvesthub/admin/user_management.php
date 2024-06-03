<?php

require_once '../database/connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>User Management</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='control.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <a href='add_user.php' class='dashboard-link'>Add User</a><br>

    <div class='content'>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Mobile Number</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['full_name'] . "</td>";
                echo "<td>" . $row['mobile_number'] . "</td>";
                echo "<td><a href='edit_user.php?user_id=" . $row['user_id'] . "'>Edit</a> | <a href='process_users.php?action=delete&user_id=" . $row['user_id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
