<?php
session_start();

if(!isset($_SESSION['u'])){
    header('location:login.php');
} else{
    echo "You have been logged in. Welcome ". $_SESSION['u']. ".";
    echo "<a href='logout.php'>Log out</a>";
}


?>