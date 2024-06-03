<?php
session_start();
$loggedIn = isset($_SESSION['userid']);
include './database/connect.php';

if (isset($_POST['selected_retailer'])) {
    $_SESSION['selected_retailer'] = $_POST['selected_retailer'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="./chatbot_func/chatbot_popup.js"></script>
</head>
<body>

<?php include './inc/harvest_header'; ?>

<div class="home-section">
    <div class="row align-items-center justify-content-center">
        <!-- Home  -->
        <div class="col-sm-12 col-md-6 order-2 order-md-1">
        <h2>About</h2>
                <p>HarvestHub is based on the principles of sustainability, community and serves as a bridge between local retailers with surplus food and eco-conscious consumers eager to make a difference. The mission is to reduce food waste at the retail and consumer levels, a significant challenge contributing to environmental and social issues.  Our unique approach not only helps in saving food from being wasted but also supports local businesses by creating an alternative revenue stream. It is more than just a platform; it's a community of like-minded individuals and businesses coming together to fight food waste.</p>
                <p><a href="/browse_retailers.php" class="view-link">View</a></p>
           
            
        </div>
        <!-- Home -->
        <div class="col-sm-12 col-md-6 order-1 order-md-2 text-md-right text-center">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/volunteers.jpg" class="d-block w-100" alt="Volunteers" width="500px" height="500px">
            </div>
            <div class="carousel-item">
                <img src="images/suppliers.jpg" class="d-block w-100" alt="Suppliers" width="500px" height="500px">
            </div>
            <div class="carousel-item">
                <img src="images/food-donation.jpg" class="d-block w-100" alt="Food Donation" width="500px" height="500px">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
        </div>
    </div>
</div>




<div class="feature">
    <div class="feature-block">
    <img src="images/grocery-cart.png" width="100" height="100" ...></img>
        <h4>Discover</h4>
        <p>Sign up to connect with local cafes, grocery stores, and restaurants offering excess food at reduced prices.  Join us in making food consumption more sustainable, one purchase at a time.</p>
    </div>
    <div class="feature-block">
    <img src="images/reserved.png" width="100" height="100" ...></img>
        <h4>Book</h4>
        <p>Reserve your desired quantity of surplus food items. Schedule a collection at  and receive instant confirmation you will directly contribute to reducing food waste. Every booking you make is a step towards a zero-waste lifestyle.</p>
    </div>
    <div class="feature-block">
        <img src="images/bot (1).png" width="100" height="100" ...></img>
        <h4>Engage with EcoChat</h4>
        <p>Designed to offer personalized guidance on zero-waste practices and getting customized meal plans to providing a zero-waste shopping list. EcoChat will be your go-to for environmental education and impact reduction.</p>
    </div>
</div>

<div class="slogan-section">
    <div class="container h-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col text-center">
                <p><i>Share the Feast, Cut the Waste.</i></p>
                <p><i>Harvesting Value, Reducing Waste.</i></p>
            </div>
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

<?php include './inc/harvest_footer'; ?>

</body>
</html>
