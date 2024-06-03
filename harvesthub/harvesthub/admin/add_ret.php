<!DOCTYPE html>
<html>
<head>
    <title>Add Retailer</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>

<div class='dashboard'>
    <h1 class='dashboard-title'>Add Retailer</h1>

    <div class='dashboard-links'>
        <a href='user_management.php' class='dashboard-link'>Manage Users</a>
        <a href='retailer_management.php' class='dashboard-link'>Manage Retailers</a>
        <a href='admin_auth.php?action=logout' class='dashboard-link'>Logout</a>
    </div>

    <div class='content'>
        <form action="process_ret.php?action=add" method="post">
            <label for="ret_name">Retailer Name:</label><br>
            <input type="text" id="ret_name" name="ret_name"><br>

            <label for="location">Location:</label><br>
            <input type="text" id="location" name="location"><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>

            <label for="image">Image URL:</label><br>
            <input type="text" id="image" name="image"><br>
            
            <input type="submit" value="Add Retailer">
        </form>
    </div>
</div>

</body>
</html>
