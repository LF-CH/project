<?php
session_start();
require_once '../database/connect.php';

if (!isset($_SESSION['adm_id'])) {
    header("Location: logout.php");
    exit;
}

$search = mysqli_real_escape_string($conn, $_GET['retailer_name']);

$sql = "SELECT * FROM retailer WHERE ret_name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Retailers</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Search Results for Retailers</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <table>
            <tr>
                <th>Retailer Name</th>
                <th>Location</th>
                <th>Description</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ret_name'] . "</td>";
                echo "<td>" . $row['location'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
