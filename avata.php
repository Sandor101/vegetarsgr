<?php

session_start();
include("connection.php");
include("functions.php");

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $query = "update user set status='1' where token='$token'";
    if($db->query($query)){
        header("Location:login.php?success=Fiók aktiválva!!");
        exit();
    }
    
}

?>