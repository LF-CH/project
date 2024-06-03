<?php

require_once '../database/connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $food_name = mysqli_real_escape_string($conn, $_POST['food_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $img = mysqli_real_escape_string($conn, $_POST['img']);
    $ret_name = mysqli_real_escape_string($conn, $_POST['ret_name']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);

   
    $sql = "INSERT INTO foods (food_name, description, price, img, ret_name, expiry_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsss", $food_name, $description, $price, $img, $ret_name, $expiry_date);
    $stmt->execute();

  
    $message = "Food item added successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Food Item</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Add Food Item</h1>

    <div class='dashboard-links'>
        <a href='food_item_management.php' class='dashboard-link'>Manage Food Items</a>
        <a href='booking_management.php' class='dashboard-link'>Manage Bookings</a>
        <a href='dashboard.php' class='dashboard-link'>Back to Dashboard</a>
        <a href='retailer_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <?php if (!empty($message)): ?>
        <p class='update-message'><?php echo $message; ?></p>
    <?php endif; ?>

    <div class='content'>
        <form action="process_food_item.php?action=add" method="post" class='food-item-form'>
            <label for="food_name" class='form-label'>Food Name:</label><br>
            <input type="text" id="food_name" name="food_name" class='form-input'><br>

            <label for="description" class='form-label'>Description:</label><br>
            <textarea id="description" name="description" class='form-textarea'></textarea><br>

            <label for="price" class='form-label'>Price:</label><br>
            <input type="text" id="price" name="price" class='form-input'><br>

            <label for="img" class='form-label'>Image URL:</label><br>
            <input type="text" id="img" name="img" class='form-input'><br>

            <label for="ret_name" class='form-label'>Retailer Name:</label><br>
            <input type="text" id="ret_name" name="ret_name" class='form-input'><br>

            <label for="expiry_date" class='form-label'>Expiry Date:</label><br>
            <input type="date" id="expiry_date" name="expiry_date" class='form-input'><br>

            <input type="submit" value="Add Food Item" class='submit-button'>
        </form>
    </div>
</div>

</body>
</html>
