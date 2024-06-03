<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['retailer_id'])) {
    header("location: retailer.php");
    exit;
}

$retailer_id = $_SESSION['retailer_id'];

//food items
$food_items_sql = "SELECT COUNT(*) as total FROM foods WHERE ret_name = (SELECT ret_name FROM retailer WHERE retailer_id = '$retailer_id')";
$food_items_result = $conn->query($food_items_sql);
$food_items_row = $food_items_result->fetch_assoc();
$total_food_items = $food_items_row['total'];

//total number of bookings
$booking_count_query = "SELECT COUNT(*) as total_bookings FROM bookings";
$booking_count_result = $conn->query($booking_count_query);
$booking_count_row = $booking_count_result->fetch_assoc();
$total_bookings = $booking_count_row['total_bookings'];

// number of accepted bookings
$accepted_booking_query = "SELECT COUNT(*) as accepted_bookings FROM bookings WHERE status = 'Accepted'";
$accepted_booking_result = $conn->query($accepted_booking_query);
$accepted_booking_row = $accepted_booking_result->fetch_assoc();
$accepted_bookings = $accepted_booking_row['accepted_bookings'];

// number of rejected bookings
$rejected_booking_query = "SELECT COUNT(*) as rejected_bookings FROM bookings WHERE status = 'Rejected'";
$rejected_booking_result = $conn->query($rejected_booking_query);
$rejected_booking_row = $rejected_booking_result->fetch_assoc();
$rejected_bookings = $rejected_booking_row['rejected_bookings'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Retailer Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Welcome to the Retailer Dashboard</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link'>Manage Bookings</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='statistics'>
        <p class='statistic-item'>Total Food Items: <?php echo $total_food_items; ?></p>
        <p class='statistic-item'>Total Bookings: <?php echo $total_bookings; ?></p>
        <p class='statistic-item'>Accepted Bookings: <?php echo $accepted_bookings; ?></p>
        <p class='statistic-item'>Rejected Bookings: <?php echo $rejected_bookings; ?></p>
    </div>

    <div class='search-section'>
        <h2 class='search-title'>Search Food Items</h2>
        <form action='search_food.php' method='get' class='search-form'>
            <input type='text' name='search_value' placeholder='Search Food Items' class='search-input'>
            <input type='submit' value='Search' class='search-button'>
        </form>

        <h2 class='search-title'>Search Bookings by Date</h2>
        <form action='search_bookings.php' method='get' class='search-form'>
            <input type='date' name='search_date' class='search-input'>
            <input type='submit' value='Search' class='search-button'>
        </form>
    </div>
</div>

</body>
</html>
