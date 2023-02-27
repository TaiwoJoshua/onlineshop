<?php
    session_start();
    ob_start();
    $server="localhost";
    $serverUsername="root";
    $serverPassword="";
    $dbName="onlineshopping";
    date_default_timezone_set('Africa/Lagos');

    $conn=new mysqli($server,$serverUsername,$serverPassword,$dbName);

    $DateTime = date('Y-m-d H:i:s');
    if(isset($_SESSION['admin'])){
        //Check for Admin Login Session Timeout
        $ttime = strtotime($DateTime) - 3600;
        $db = $conn->query("SELECT * FROM `admin`");
        if($db->num_rows > 0){
            while($row = $db->fetch_assoc()){
                $time = $row['time'];
            }
            $ntime = strtotime($time);
            
            if($ntime > $ttime){
                
            }else{
                session_destroy();
            }
        }
    }

    if(isset($_SESSION['username'])){
        //Check for Customer Login Session Timeout
        $username = $_SESSION['username'];
        $ttime = strtotime($DateTime) - (3600 * 24);
        $db = $conn->query("SELECT * FROM `customers` WHERE `username`='$username'");
        if($db->num_rows > 0){
            while($row = $db->fetch_assoc()){
                $time = $row['time'];
            }
            $ntime = strtotime($time);
            
            if($ntime > $ttime){
                
            }else{
                session_destroy();
            }
        }
    }
?>