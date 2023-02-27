<?php
    include './dbconnect.php';

    if(isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        if(isset($_SESSION['createtable']) && $_SESSION['createtable'] == 1){
            $conn->query("DROP TABLE `$username`");
        }
    }

    session_destroy();
    header('location: ./preloader.php');
?>
