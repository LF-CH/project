<?php
require_once '../database/connect.php';

$retailer_id = $_GET['retailer_id'];
$sql = "SELECT * FROM retailer WHERE retailer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $retailer_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Retailer</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Edit Retailer</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <form action='process_ret.php?action=edit&id=<?php echo $retailer_id; ?>' method='post'>
            <label for='ret_name'>Retailer name:</label><br>
            <input type='text' id='ret_name' name='ret_name' value='<?php echo $row['ret_name']; ?>'><br>

            <label for='location'>Location:</label><br>
            <textarea id='location' name='location'><?php echo $row['location']; ?></textarea><br>

            <label for='description'>Description</label><br>
            <input type='text' id='description' name='description' value='<?php echo $row['description']; ?>'><br>

            <label for='image'>Image URL:</label><br>
            <input type='text' id='image' name='image' value='<?php echo $row['image']; ?>'><br>

            <input type='submit' value='Update Retailer'>
        </form>
    </div>
</div>

</body>
</html>
