<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}

$sql = "SELECT * FROM `cars`";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $cars = $stmt->fetchAll();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Table V01</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
    <body>
    <?php require_once "includes/nav.php"; ?>
        <div id="wrapper">
         <h1>Cars List</h1>
         
         <table id="keywords" cellspacing="0" cellpadding="0">
           <thead>
             <tr>
               <th><span>Car Title</span></th>
               <th><span>Price</span></th>
               <th><span>Model</span></th>
               
               <th><span>Delete</span></th>
               <th><span>Update</span></th>
             </tr>
           </thead>
           <tbody>

           <?php
            foreach($cars as $car){
           ?>
             <tr>
               <td class="lalign"><?php echo $car['title']; ?></td>
               <td><?php echo $car['price']; ?></td>
               <td><?php echo $car['model']; ?></td>
               
               
               <td><a href="delete.php?id=<?php  echo $car['id']; ?>" onclick="return confirm('Are You Sure ?')" ><img src="../img/delete.jpg"></a> </td>
               <td><a href="UpdateCar.php?id=<?php  echo $car['id']; ?>" ><img src="../img/update.jpg"></a> </td>
             </tr>
            <?php
            }
            ?>
           </tbody>
         </table>
        </div> 
       </body>
</body>
</html>
