<?php
session_start();
include './database/connect.php'; 


$loggedIn = isset($_SESSION['userid']);
if (!$loggedIn) {
    
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['userid'];


$sql_user = "SELECT username, email, full_name, mobile_number FROM users WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$user_result = $stmt_user->get_result();
$user_details = $user_result->fetch_assoc();


$sql_bookings = "SELECT bookings_id, collection_date, collection_time, total_amount,status FROM bookings WHERE user_id = ? ORDER BY collection_date DESC, collection_time DESC";
$stmt_bookings = $conn->prepare($sql_bookings);
$stmt_bookings->bind_param("i", $user_id);
$stmt_bookings->execute();
$bookings_result = $stmt_bookings->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="cart.js"></script>
</head>
<body>
<?php include './inc/harvest_header'; ?>

<div class="retail_container mt-4">
        
        <img src="images/profile-user.png" class="profile-icon">
        <div class="row">
        <div class="col-md-6">
        <section class="profile-section mb-4">
        <h2>User Details</h2>
        <p>Username: <?php echo htmlspecialchars($user_details['username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user_details['email']); ?></p>
        <p>Full Name: <?php echo htmlspecialchars($user_details['full_name']); ?></p>
        <p>Mobile Number: <?php echo htmlspecialchars($user_details['mobile_number']); ?></p>
    </section>
        </div>

    <div class="col-md-6">
    <section class="profile-section">
        <h2>Booking Information</h2>
        <div class="responsive-table">
        <?php if ($bookings_result->num_rows > 0): ?>
            <div class="table-responsive">
                    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Collection Date</th>
                        <th>Collection Time</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['bookings_id']); ?></td>
                            <td><?php echo htmlspecialchars($booking['collection_date']); ?></td>
                            <td><?php echo htmlspecialchars($booking['collection_time']); ?></td>
                            <td><?php echo htmlspecialchars($booking['total_amount']); ?></td>
                            <td><?php echo htmlspecialchars($booking['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No booking details found.</p>
        <?php endif; ?>
        </div>
    </section>
</div>
        </div>
</div>

<button class="chatbot-btn" onclick="toggleChatbot()">EcoChat</button>

<!--  (hidden) -->
<div id="chatbot-container">
    <div id="chatbot-header">Chatbot</div>
    <div id="chatbot-messages"></div>
    <div id="chatbot-input-area">
        <input type="text" id="chatbot-input" placeholder="Type a message...">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <?php include './inc/harvest_footer'; ?>
</body>
</html>
