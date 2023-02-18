<?php
    include './dbconnect.php';

    $username = $_SESSION['username'];
    if($_SESSION['createtable'] == 1){
        $conn->query("DROP TABLE `$username`");
    }

    session_destroy();
    header('location: ./preloader.php');
?>
