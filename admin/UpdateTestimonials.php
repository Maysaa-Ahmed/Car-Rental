<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $sql = "UPDATE `testimonials` SET `name`=?,`position`=?,`content`=?,`image`=? WHERE `id` = ?";
   
	$stmt = $conn->prepare($sql);
	
    $name = $_POST['name'];
    $position = $_POST['position'];
	$content = $_POST['content'];
	$id = $_POST['id'];

	//$image = 'image';
	$oldImage = $_POST['oldImage'];
	require_once "includes/updateImage.php";
	
	
	$stmt->execute([$name, $position, $content, $image_name, $id]);
	
echo "done";
}

if(isset($_GET['id'])){
    $sql = "SELECT * FROM `testimonials` WHERE id = ?";
   
    $stmt = $conn->prepare($sql);
    
    $id = $_GET['id'];
	$stmt->execute([$id]);
	
	$testimonial = $stmt->fetch();

	if ($testimonial === false) {
        header('Location: testimonials.php');
        die();
    }

} else{
	header('Location: testimonials.php');
   die();
}



?>




<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Edit / Update Testimonials</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	</head>

	<body>
		<div class="container">
			<form method="POST" action="" class="m-auto" style="max-width:600px" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="oldImage" value="<?php echo $testimonial['image'] ?>">
				<h3 class="my-4">Edit / Update Testimonials</h3>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="title2" class="col-md-5 col-form-label">Name</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="title2"  name="name" value="<?php echo $testimonial['name']; ?>"  required></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="price6" class="col-md-5 col-form-label">position</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="price6" name="position" value="<?php echo $testimonial['position']; ?>"></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="content4" class="col-md-5 col-form-label">Content</label>
					<div class="col-md-7"><textarea class="form-control form-control-lg" id="content4" name="content" required><?php echo $testimonial['content']; ?></textarea></div>
				</div>
				<hr class="my-4" />
				<img src="../img/testimonial-2.jpg" style="width:100px; height:100px;">
				<div>
					<label for="image" class="col-md-5 col-form-label">Select Image</label>
					<input type="file" id="image" name="image" accept="image/*">
					<img src="../img/<?php echo $testimonial['image'] ?>" alt="">
				</div>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" type="submit">Update</button></div>
				</div>
			</form>
		</div>
	</body>

</html>