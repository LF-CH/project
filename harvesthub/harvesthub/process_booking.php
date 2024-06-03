<?php
session_start();
include './database/connect.php'; 

if (isset($_SESSION['userid']) && $_POST['cart_data'] && $_POST['total_amount']) {
    $user_id = $_SESSION['userid'];
    $cart_data = json_decode($_POST['cart_data'], true);
    $total_amount = $_POST['total_amount'];
    $collection_date = $_POST['collection_date'];
    $collection_time = $_POST['collection_time'];

    $conn->begin_transaction();

    try {
        
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, collection_date, collection_time, status, total_amount) VALUES (?, ?, ?, 'Pending', ?)");
        $stmt->bind_param("issd", $user_id, $collection_date, $collection_time, $total_amount);
        $stmt->execute();
        $booking_id = $conn->insert_id;

      
        foreach ($cart_data as $food_id => $item) {
            $stmt = $conn->prepare("INSERT INTO booking_details (booking_id, food_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $booking_id, $food_id, $item['quantity'], $item['price']);
            $stmt->execute();
        }

        $conn->commit();

       
        header("Location: payment.php?booking_id=" . $booking_id);
        exit();
    } catch (Exception $e) {
       
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>
