<?php
session_start();


if (!isset($_SESSION['adm_id'])) {
    header("Location: logout.php");
    exit;
}


require_once '../database/connect.php';

$user_count_query = "SELECT COUNT(*) as total_users FROM users";
$user_count_result = $conn->query($user_count_query);
$user_count_row = $user_count_result->fetch_assoc();
$total_users = $user_count_row['total_users'];

$retailer_count_query = "SELECT COUNT(*) as total_retailers FROM retailer";
$retailer_count_result = $conn->query($retailer_count_query);
$retailer_count_row = $retailer_count_result->fetch_assoc();
$total_retailers = $retailer_count_row['total_retailers'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Welcome to the Admin Dashboard</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='statistics'>
        <p>Total Users: <?php echo $total_users; ?></p>
        <p>Total Retailers: <?php echo $total_retailers; ?></p>
    </div>

    <div class='search-section'>
        <h2>Search</h2>
        <form action='search_users.php' method='get' class='search-form'>
            <input type='text' name='username' placeholder='Search Users by Username' class='search-input'>
            <input type='submit' value='Search Users' class='search-button'>
        </form>

        <form action='search_retailers.php' method='get' class='search-form'>
            <input type='text' name='retailer_name' placeholder='Search Retailers by Name' class='search-input'>
            <input type='submit' value='Search Retailers' class='search-button'>
        </form>
    </div>
</div>

</body>
</html>
