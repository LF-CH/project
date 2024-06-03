<?php
session_start();
require_once '../database/connect.php'; 

$message = '';


if (isset($_SESSION['adm_id'])) {
   
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
      
        $_SESSION = array();
        session_destroy();

      
        header("Location: admin.php");
        exit;
    } else {
      
        header("Location: control.php");
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT adm_id, username, password FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['adm_id'] = $row['adm_id']; 
            $_SESSION['username'] = $row['username'];
            header("Location: control.php");
            exit;
        } else {
            $message = 'Invalid username or password.';
        }
    } else {
        $message = 'User not found.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<div class="form-container">
        <h1 class="form-title">Login</h1>
        <form method="post" action="admin.php">
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




