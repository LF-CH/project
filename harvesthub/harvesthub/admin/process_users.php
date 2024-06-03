<?php
require_once '../database/connect.php';

$action = $_GET['action'];

if ($action == 'add') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];
   
    $sql = "INSERT INTO users (username, password, email, full_name, mobile_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $password, $email, $full_name, $mobile_number);
    $stmt->execute();
} elseif ($action == 'edit') {
    $user_id = $_GET['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $mobile_number = $_POST['mobile_number'];

    $sql = "UPDATE users SET username = ?, password = ?,  email = ?, full_name = ?, mobile_number = ?, WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssii", $username, $password, $email, $full_name, $mobile_number, $user_id);
    $stmt->execute();
} elseif ($action == 'delete') {
    $id = $_GET['user_id'];
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: user_management.php");
?>
