<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}

$sql = "SELECT * FROM `testimonials`";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $testimonials = $stmt->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Testimonials</title>
    <link rel="stylesheet" href="cars.css">
</head>
<body>
    <body>
        <div id="wrapper">
         <h1>Testimonials List</h1>
         
         <table id="keywords" cellspacing="0" cellpadding="0">
           <thead>
             <tr>
               <th><span>Name</span></th>
               <th><span>Position</span></th>
               <th><span>Delete</span></th>
               <th><span>Update</span></th>
             </tr>
           </thead>
           <tbody>

              <?php
              foreach($testimonials as $testimonial){
              ?>
             <tr>
               <td class="lalign"><?php echo $testimonial['name']; ?></td>
               <td><?php echo $testimonial['position']; ?></td>
               <td><a href="delete_testimonials.php?id=<?php  echo $testimonial['id']; ?>" onclick="return confirm('Are You Sure ?')" ><img src="../img/delete.jpg"></a> </td>
               <td><a href="UpdateTestimonials.php?id=<?php  echo $testimonial['id']; ?>" ><img src="../img/update.jpg"></a> </td>
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
