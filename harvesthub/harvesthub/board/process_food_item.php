<?php
require_once '../database/connect.php';

$action = $_GET['action'];

if ($action == 'add') {
    $ret_name = $_POST['ret_name'];
    $food_name = $_POST['food_name'];
    $img = $_POST['img'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO foods (ret_name, food_name, img, description, price, expiry_date) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $ret_name, $food_name, $img, $description, $price, $expiry_date);
    $stmt->execute();
} elseif ($action == 'edit') {
    $id = $_GET['id'];
    $food_name = $_POST['food_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $ret_name = $_POST['ret_name'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "UPDATE foods SET ret_name = ?, food_name = ?,  img = ?, description = ?, price = ?, expiry_date = ? WHERE food_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $ret_name, $food_name, $img, $description, $price, $expiry_date, $id);
    $stmt->execute();
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM foods WHERE food_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: food_item_management.php");
?>
