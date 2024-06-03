<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Add User</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <form action="process_users.php?action=add" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>

            <label for="password">Password:</label><br>
            <textarea id="password" name="password"></textarea><br>

            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br>

            <label for="full_name">Full name:</label><br>
            <input type="text" id="full_name" name="full_name"><br>

            <label for="mobile_number">Mobile number:</label><br>
            <input type="text" id="mobile_number" name="mobile_number"><br>

            <input type="submit" value="Add User">
        </form>
    </div>
</div>

</body>
</html>
