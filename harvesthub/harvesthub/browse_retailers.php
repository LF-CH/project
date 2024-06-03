<?php
session_start();
$loggedIn = isset($_SESSION['userid']);
include './database/connect.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

if (isset($_POST['selected_retailer'])) {
    $_SESSION['selected_retailer'] = $_POST['selected_retailer'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Retailers</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="cart.js"></script>
</head>
<body>

<?php include './inc/harvest_header'; ?>

<div class="page-wrapper">
    <div class="top-links">
        <div class="retail_container">
            <ul class="links">
                <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="#">Choose Retailer</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="#">Choose from local surplus food</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Book and collect</a></li>
            </ul>
</div>
    </div>
            <!-- Search Form -->
            <form action="browse_retailers.php" method="get" class="search-form">
                <input type="text" name="search" placeholder="Search for a retailer" class="search-input">
                <button type="submit" class="btn btn-primary search-btn">Search</button>
            </form>
        
   

    <section class="my-5">
        <div class="retail_container">
            <?php if ($loggedIn): ?>
                <div class="result-show">
                    
                    <?php
                    $sql = "SELECT ret_name, description, image FROM retailer WHERE ret_name LIKE ?";
                    $stmt = $conn->prepare($sql);
                    $searchTermLike = "%" . $searchTerm . "%";
                    $stmt->bind_param("s", $searchTermLike);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='row mb-4 retailer-card'>"; 

                          
                            echo "<div class='col-md-8'>";
                            echo "<div class='media'>";
                            echo "<img class='mr-3' style='width:150px; height:8rem;' src='images/" . htmlspecialchars($row["image"]) . "' alt='" . htmlspecialchars($row["ret_name"]) . "'>";
                            echo "<div class='media-body'>";
                            echo "<h5 class='mt-0'>" . htmlspecialchars($row["ret_name"]) . "</h5>";
                            echo "<p class='descr'>" . htmlspecialchars($row["description"]) . "</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";

                        
                            echo "<div class='col-md-4 d-flex align-items-center'>";
                            echo "<a class='btn btn-primary' href='browse_food.php?ret_name=" . urlencode($row["ret_name"]) . "' onclick='setSelectedRetailer(\"" . htmlspecialchars($row["ret_name"], ENT_QUOTES) . "\")'>View Items</a>";
                            echo "</div>";

                            echo "</div>"; 
                        }
                    } else {
                        echo "<p>No retailers found.</p>";
                    }
                    ?>
                </div>
            <?php else: ?>
                <p>Please log in to view retailers.</p>
            <?php endif; ?>
        </div>
    </section>


<script>
function setSelectedRetailer(retailerName) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'set_retailer_session.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('selected_retailer=' + encodeURIComponent(retailerName));
}
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
