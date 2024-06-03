<?php

session_start();

$loggedIn = isset($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<?php include './inc/harvest_header'; ?>

<div class="payment-container">
    <h1 class="payment-title">Payment</h1>
    <?php if ($loggedIn): ?>
      
        <div class="payment-form-wrapper">
            <form action="profile.php" method="post" class="payment-form">
                <div class="payment-input-group">
                    <label for="card_number" class="payment-label">Credit Card Number:</label>
                    <input type="text" id="card_number" name="card_number" class="payment-input" required pattern="[0-9]{16}">
                </div>

                <div class="payment-input-group">
                    <label for="expiry_date" class="payment-label">Expiry Date:</label>
                    <input type="date" id="expiry_date" name="expiry_date" class="payment-input" required>
                </div>

                <div class="payment-input-group">
                    <label for="cvv" class="payment-label">CVV:</label>
                    <input type="text" id="cvv" name="cvv" class="payment-input" required pattern="[0-9]{3}">
                </div>

                <button type="submit" class="payment-submit-btn">Pay and Collect</button>
            </form>
        </div>
    <?php else: ?>
        <p class="login-prompt">Please login to make a payment.</p>
    <?php endif; ?>

    
</div>

</body>
</html>

