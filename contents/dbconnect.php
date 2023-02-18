<?php
    session_start();
    ob_start();
    $server="localhost";
    $serverUsername="root";
    $serverPassword="";
    $dbName="onlineshopping";
    date_default_timezone_set('Africa/Lagos');

    $conn=new mysqli($server,$serverUsername,$serverPassword,$dbName);

?>