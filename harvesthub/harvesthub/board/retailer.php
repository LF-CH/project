<?php
session_start();
include '../database/connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT retailer_id FROM retailer_dash WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['retailer_id'] = $row['retailer_id'];
        header("location: dashboard.php");
    } else {
        $message = 'Login Failed';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="form-container">
        <h1 class="form-title">Login</h1>
        <form method="post" action="retailer.php">
            <div class="form-group">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input">
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-input">
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="form-btn">
            </div>
        </form>
        <?php echo $message; ?>
    </div>
</body>
</html>
