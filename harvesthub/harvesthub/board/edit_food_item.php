<?php
require_once '../database/connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM foods WHERE food_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "<form action='process_food_item.php?action=edit&id=$id' method='post'>";
echo "<label for='food_name'>Food Name:</label><br>";
echo "<input type='text' id='food_name' name='food_name' value='".$row['food_name']."'><br>";

echo "<label for='description'>Description:</label><br>";
echo "<textarea id='description' name='description'>".$row['description']."</textarea><br>";

echo "<label for='price'>Price:</label><br>";
echo "<input type='text' id='price' name='price' value='".$row['price']."'><br>";

echo "<label for='img'>Image URL:</label><br>";
echo "<input type='text' id='img' name='img' value='".$row['img']."'><br>";

echo "<label for='ret_name'>Retailer Name:</label><br>";
echo "<input type='text' id='ret_name' name='ret_name' value='".$row['ret_name']."'><br>";

echo "<label for='expiry_date'>Expiry Date:</label><br>";
echo "<input type='date' id='expiry_date' name='expiry_date' value='".$row['expiry_date']."'><br>";

echo "<input type='submit' value='Update Food Item'>";
echo "</form>";
?>
