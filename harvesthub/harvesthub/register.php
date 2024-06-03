<?php
session_start(); 
require_once './database/connect.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    $sql = "INSERT INTO users (username, password, email, full_name, mobile_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $password, $email, $fullname, $mobile);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $message = 'Registration failed!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-container">
    <div class="form-container">
        <div class="register-form">
            <h3 class="form-title">User Registration</h3>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="fullname" class="form-label">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="mobile" class="form-label">Mobile Number:</label>
                    <input type="tel" id="mobile" name="mobile" class="form-input" required>
                </div>

                <button type="submit" class="form-btn">Register</button>
            </form>
            <?php if ($message): ?>
                <p class="form-message"><?php echo $message; ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>

