<?php
session_start();

if (isset($_SESSION['adm_id'])) {
   
    $_SESSION = array();
    session_destroy();
}


header("Location: admin.php");
exit;
?>
