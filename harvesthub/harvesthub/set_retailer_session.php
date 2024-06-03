<?php
session_start();

if (isset($_POST['selected_retailer'])) {
    $_SESSION['selected_retailer'] = $_POST['selected_retailer'];
}
?>
