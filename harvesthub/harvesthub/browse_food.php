<?php
session_start();
include './database/connect.php';
$loggedIn = isset($_SESSION['userid']);
$ret_name = isset($_GET['ret_name']) ? $_GET['ret_name'] : '';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Food</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  
    <script src="cart_func.js"></script>
</head>
<body>

<?php include './inc/harvest_header'; ?>

<div class="page-wrapper">
    <div class="top-links">
        <div class="retail_container">
            <ul class="links">
                <li class="col-xs-12 col-sm-4 link-item"><span>1</span><a href="#">Choose Retailer</a></li>
                <li class="col-xs-12 col-sm-4 link-item active"><span>2</span><a href="#">Choose from local surplus food</a></li>
                <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="#">Book and collect</a></li>
            </ul>
        </div>
    </div>

    <div class="search-bar">
    <input type="text" id="food-search" placeholder="Search for food..." onkeyup="searchFood()">
</div>

<div class="bfood-container">

    <div class="food-items-container">
    <h2 class="text-center">Browse Food</h2>
            <?php if ($loggedIn && $ret_name): ?>
          
                <?php
                $sql = "SELECT food_id, food_name, description, img, price, expiry_date FROM foods WHERE ret_name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $ret_name);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='food-item'>";
                        echo "<img src='images/" . htmlspecialchars($row["img"]) . "' alt='" . htmlspecialchars($row["food_name"]) . "'>";
                        echo "<h2>" . htmlspecialchars($row["food_name"]) . "</h2>";
                        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
                        echo "<p>Price: $" . htmlspecialchars($row["price"]) . "</p>";
                        echo "<p>Expiry Date: " . htmlspecialchars($row["expiry_date"]) . "</p>";
                        echo "<button onclick='addToCart(" . json_encode($row["food_id"]) . ", " . json_encode(htmlspecialchars($row["food_name"])) . ", " . json_encode(floatval($row["price"])) . ")'>Add to Cart</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No food items found for this retailer.</p>";
                }
                $stmt->close();
                ?>
            <?php else: ?>
                <p>Please log in and select a retailer to view food items.</p>
            <?php endif; ?>
        </div>
        
        <div class="cart-container">

    <div id="cart" class="">
     
        <div id="cart-items">
   
        </div>
        <div class="cart-total">
            <span>Total:</span>
            <span id="cart-total-amount">$0.00</span>
        </div>
        </div>
    
        
</div>
    </div>
</div>
</div>

<form id="cart_form" action="bookings.php" method="post" style="display:none;">
    <input type="hidden" id="cart_data_input" name="cart_data" />
    <input type="hidden" id="total_amount_input" name="total_amount" />
    <input type="hidden" id="booking_id_input" name="booking_id" value="<?php echo isset($booking_id) ? htmlspecialchars($booking_id) : ''; ?>">
</form>

<script src="searchFood.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<?php include './inc/harvest_footer'; ?>

<script>
function searchFood() {
    var input, filter, foodContainer, foodItems, title, i, txtValue;
    input = document.getElementById('food-search');
    filter = input.value.toUpperCase();
    foodContainer = document.getElementsByClassName('food-items-container')[0];
    foodItems = foodContainer.getElementsByClassName('food-item');

    for (i = 0; i < foodItems.length; i++) {
        title = foodItems[i].getElementsByTagName("h2")[0];
        txtValue = title.textContent || title.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            foodItems[i].style.display = "";
        } else {
            foodItems[i].style.display = "none";
        }
    }
}
</script>

</body>
</html>
