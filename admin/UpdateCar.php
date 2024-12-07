<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}

require_once "includes/conn.php";


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $sql = "UPDATE `cars` SET `title`=?,`content`=?,`price`=?,`model`=?,`type`=?,`properties`=?,`published`=?,`image`=? WHERE `id` = ?";
   
	$stmt = $conn->prepare($sql);
	
    $title = $_POST['title'];
    $price = $_POST['price'];
	$model = $_POST['model'];
	$content = $_POST['content'];
	$type = $_POST['type'];
	$properties = $_POST['properties'];
	$id = $_POST['id'];

	//$image = 'image';
	$oldImage = $_POST['oldImage'];
	require_once "includes/updateImage.php";


	if(isset($_POST['$published'])){
		$published = 1;
	} else{
		$published = 0;
	}
	
	
	$stmt->execute([$title, $content, $price, $model, $type, $properties, $published, $image_name, $id]);
	
echo "done";
}

if(isset($_GET['id'])){
    $sql = "SELECT * FROM `cars` WHERE id = ?";
   
    $stmt = $conn->prepare($sql);
    
    $id = $_GET['id'];
	$stmt->execute([$id]);
	
	$car = $stmt->fetch();

	if ($car === false) {
        header('Location: cars.php');
        die();
    }

} else{
	header('Location: cars.php');
   die();
}



?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Edit / Update Car</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	</head>

	<body>
		<div class="container">
			<form method="POST" action="" class="m-auto" style="max-width:600px" enctype="multipart/form-data">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="oldImage" value="<?php echo $car['image'] ?>">
				<h3 class="my-4">Edit / Update Car</h3>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="title2" class="col-md-5 col-form-label">Car Title</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="title2" value="<?php echo $car['title']; ?>" name="title" required></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="content4" class="col-md-5 col-form-label">Content</label>
					<div class="col-md-7"><textarea class="form-control form-control-lg" id="content4" name="content" required><?php echo $car['content']; ?></textarea></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="price6" class="col-md-5 col-form-label">Price</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="price6" value="<?php echo $car['price']; ?>" name="price"></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="model6" class="col-md-5 col-form-label">Model</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="model6" value="<?php echo $car['model']; ?>" name="model"></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="select-option1" class="col-md-5 col-form-label">Auto / Manual</label>
					<div class="col-md-7"><select class="form-select custom-select custom-select-lg" id="select-option1" name="type">
							<option value= "auto" <?php echo ($car['type'] === "auto")? "selected":"" ?> >Auto</option>
							<option value= "manual" <?php echo ($car['type'] === "manual")? "selected":"" ?> >Manual</option>
							
						</select></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="properties6" class="col-md-5 col-form-label">Properties</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="properties6" value="<?php echo $car['properties']; ?>" name="properties"></div>
				</div>
				<div class="form-group mb-3 row">
					<label for="" class="form-check-label col-md-5">
					Published
					</label>
					<div class="col-md-7"><input type="checkbox" name="published" id="" class="form-check-input" <?php echo ($car['published'] === 1)? "checked":"" ?>  ></div>
					</div>
				<hr class="my-4" />
				<div>
					<label for="image" class="col-md-5 col-form-label">Select Image</label>
					<input type="file" id="image" name="image" accept="image/*">
				</div>
				<img src="../img/<?php echo $car['image'] ?>" alt="">
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" type="submit">Update</button></div>
				</div>
			</form>
		</div>
	</body>

</html>