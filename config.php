<?php
    $servername="sql303.iceiy.com";
    $username="icei_30207525";
    $password="southern123"; 
    $database="icei_30207525_cart2021c";
    $conn=new mysqli($servername, $username, $password,$database);
    
    // Check connection
    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }
    
?>