<?php 
    $conn=new mysqli("localhost","root","","cart_system");
    if($conn->connect_error){
      die("Connectin Failed".$conn->connect_error);
    }
   
?>