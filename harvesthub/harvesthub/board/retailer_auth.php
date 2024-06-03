<?php
session_start();

if (isset($_SESSION['ret_name'])) {
   
    $_SESSION = array();
    session_destroy();
}

header("Location: retailer.php");
exit;
?>
