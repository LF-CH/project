<?php
require_once '../database/connect.php';

$action = $_GET['action'];

if ($action == 'add') {
    $ret_name = $_POST['ret_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $sql = "INSERT INTO retailer (ret_name, location, description, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $ret_name, $location, $description, $image);
    $stmt->execute();
} elseif ($action == 'edit') {
    $retailer_id = $_GET['retailer_id'];
    $ret_name = $_POST['ret_name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $image = $_POST['image'];

    $sql = "UPDATE retailer SET ret_name = ?, location = ?, description = ?, image = ? WHERE retailer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $ret_name, $location, $description, $image, $retailer_id);
    $stmt->execute();
} elseif ($action == 'delete') {
    $retailer_id = $_GET['retailer_id'];
    $sql = "DELETE FROM retailer WHERE retailer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $retailer_id);
    $stmt->execute();
}

header("Location: retailer_management.php");
?>
