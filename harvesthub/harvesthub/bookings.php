<?php

$cart_data = [];

session_start();
include './database/connect.php'; 

$loggedIn = isset($_SESSION['userid']);
$latest_booking = null; 


if ($loggedIn) {
   
    if (isset($_POST['cart_data'])) {
        $cart_data = json_decode($_POST['cart_data'], true);
    } else {
        error_log("Cart data not set in the form submission.");
       
    }
}


if ($loggedIn && isset($_POST['submit_booking'])) {
    $user_id = $_SESSION['userid'];
    $collection_date = $_POST['collection_date'];
    
    $collection_time = date("H:i", strtotime($_POST['collection_time']));
    
    $total_amount = $_POST['total_amount'];
    
    $status = 'Pending';

    $ret_name = $_SESSION['selected_retailer'] ?? 'Unknown'; 

    $insert_booking = "INSERT INTO bookings (user_id, collection_date, collection_time, status, total_amount, ret_name) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert_booking = $conn->prepare($insert_booking);
    $stmt_insert_booking->bind_param("isssds", $user_id, $collection_date, $collection_time, $status, $total_amount, $ret_name);
    if (!$stmt_insert_booking->execute()) {
        error_log("Error in booking insert query: " . $stmt_insert_booking->error);
       
    }
    $booking_id = $conn->insert_id;

    if (is_array($cart_data)) { 
        foreach ($cart_data as $food_id => $item) {
            $insert_item = "INSERT INTO booking_details (booking_id, food_id, quantity) VALUES (?, ?, ?)";
            $stmt_insert_item = $conn->prepare($insert_item);
            $stmt_insert_item->bind_param("iii", $booking_id, $food_id, $item['quantity']);
            if (!$stmt_insert_item->execute()) {
                error_log("Error in booking details insert query: " . $stmt_insert_item->error);
               
            }
        }
    } else {
        error_log("Cart data is not an array.");

    }

    header("Location: payment.php");

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="cart.js"></script>
</head>
<body>

<?php include './inc/harvest_header'; ?>

    <div class="page-wrapper">
    <div class="top-links">
        <div class="retail_container">
            <ul class="links">
                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="#">Choose Retailer</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Choose from local surplus food</a></li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>3</span><a href="#">Book and collect</a></li>
            </ul>
        </div>
    </div>
    <h2 class="booking-title">Your Booking</h2>

    <div class="items-summary">
        <h3>Selected Items</h3>
        <ul class="item-list">
            <?php foreach ($cart_data as $food_id => $item): ?>
                <li class="item-detail"><?php echo $item['quantity']; ?> x <?php echo $item['name']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="booking-form-container">
        <form action="bookings.php" method="post" class="booking-form">
            <div class="input-group">
                <label for="collection_date" class="label">Collection Date:</label>
                <input type="date" id="collection_date" name="collection_date" class="input-field" required>
            </div>

            <div class="input-group">
                <label for="collection_time" class="label">Collection Time:</label>
                <input type="time" id="collection_time" name="collection_time" class="input-field" required>
            </div>

            <input type="hidden" id="total_amount_input" name="total_amount">
            <button type="submit" name="submit_booking" class="submit-btn">Confirm Booking</button>
        </form>
    </div>
</div>

    <script>

        document.querySelector('form').addEventListener('submit', function() {

            document.getElementById('total_amount_input').value = calculateTotalAmount();
        });

        function calculateTotalAmount() {
            var cartItems = <?php echo json_encode($cart_data); ?>;
            var total = 0;
            for (var food_id in cartItems) {
                total += cartItems[food_id]['quantity'] * cartItems[food_id]['price'];
            }
            return total;
        }
    </script>

<?php include './inc/harvest_footer'; ?>
</body>
</html>
