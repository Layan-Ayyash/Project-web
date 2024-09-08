<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['id'])) {
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; 
        header("Location: login1.php");
        exit();
    }
}
?>
