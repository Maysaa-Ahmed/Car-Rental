<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}

require_once "includes/conn.php";

if(isset($_GET['id'])){
    $sql = "DELETE FROM `testimonials` WHERE id = ?";
   
    $stmt = $conn->prepare($sql);
    
    $id = $_GET['id'];
    $stmt->execute([$id]); 
} 
header('Location: testimonials.php');
die();


?>