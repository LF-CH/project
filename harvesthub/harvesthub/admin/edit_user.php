<?php
require_once '../database/connect.php';

$user_id = $_GET['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Edit User</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <form action='process_users.php?action=edit&id=<?php echo $user_id; ?>' method='post'>
            <label for='username'>Username:</label><br>
            <input type='text' id='username' name='username' value='<?php echo $row['username']; ?>'><br>

            <label for='password'>Password:</label><br>
            <textarea id='password' name='password'><?php echo $row['password']; ?></textarea><br>

            <label for='email'>Email:</label><br>
            <input type='text' id='email' name='email' value='<?php echo $row['email']; ?>'><br>

            <label for='full_name'>Full name:</label><br>
            <input type='text' id='full_name' name='full_name' value='<?php echo $row['full_name']; ?>'><br>

            <label for='mobile_number'>Mobile number:</label><br>
            <input type='text' id='mobile_number' name='mobile_number' value='<?php echo $row['mobile_number']; ?>'><br>

            <input type='submit' value='Update User'>
        </form>
    </div>
</div>

</body>
</html>
