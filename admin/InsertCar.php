<?php
//redirect user to login if he is not logged in
session_start();
require_once "includes/conn.php";

if(!isset($_SESSION['logged']) || !($_SESSION['logged'] === true)){
  header('Location:login.php');
     die();
}


if ($_SERVER["REQUEST_METHOD"] === "POST"){
	if(!empty($_POST["cat_id"])){
    try{
    $sql = "INSERT INTO `cars`(`title`, `price`, `model`, `content`,`type`, `properties`, `image`, `cat_id`) VALUES (?,?,?,?,?,?,?,?)";
   
	$stmt = $conn->prepare($sql);
	
    $title = $_POST['title'];
    $price = $_POST['price'];
	$model = $_POST['model'];
	$content = $_POST['content'];
	$type = $_POST['type'];
	$properties = $_POST['properties'];
	
	//$image = 'image';
	
	$cat_id = $_POST['cat_id'];
	require_once "includes/addimage.php";

	
    $stmt->execute([$title, $price, $model, $content, $type, $properties, $image_name, $cat_id]);

   // Echo "Data Stored Successfuly!";
   header('Location: cars.php');
   die();
  }catch(PDOException $e){
    $erorr = "Connection failed: " . $e->getMessage();
  }
}else{
	echo "category is required!";
}
  }

  $sqlcat = "SELECT * FROM `categories`";
  $stmtcat = $conn->prepare($sqlcat);
  $stmtcat->execute();

$categories = $stmtcat->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Insert Car</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
		
	</head>

	<body>
	<?php require_once "includes/nav.php"; ?>
		<div class="container">
			<form method="POST" action="" class="m-auto" style="max-width:600px" enctype="multipart/form-data">
				<h3 class="my-4">Insert Car</h3>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="title2" class="col-md-5 col-form-label">Car Title</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="title2" name="title" required></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="content4" class="col-md-5 col-form-label">Content</label>
					<div class="col-md-7"><textarea class="form-control form-control-lg" id="content4" name="content" required></textarea></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="price6" class="col-md-5 col-form-label">Price</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="price6" name="price"></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="model6" class="col-md-5 col-form-label">Model</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="model6" name="model"></div>
				</div>
				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="select-option1" class="col-md-5 col-form-label">Auto / Manual</label>
					<div class="col-md-7">
					<select class="form-select custom-select custom-select-lg" id="select-option1" name="type">
							<option value="auto">Auto</option>
							<option value="manual">Manual</option>
							
						</select></div>
				</div>

				<div class="form-group mb-3 row"><label for="select-option1" class="col-md-5 col-form-label">Category</label>
					<div class="col-md-7"><select class="form-select custom-select custom-select-lg" id="select-option1" name="cat_id">
						<option value="">Select Category</option>
						<?php 
							foreach($categories as $category){
						?>
						<option value="<?php echo $category['id'] ?>"><?php echo $category['cat_name'] ?></option>

						<?php 
							}
						?>
						</select></div>
				</div>

				<hr class="bg-transparent border-0 py-1" />
				<div class="form-group mb-3 row"><label for="properties6" class="col-md-5 col-form-label">Properties</label>
					<div class="col-md-7"><input type="text" class="form-control form-control-lg" id="properties6" name="properties"></div>
				</div>
				<hr class="my-4" />
				<div>
					<label for="image" class="col-md-5 col-form-label">Select Image</label>
					<input type="file" id="image" name="image" accept="image/*">
				</div>
				<hr class="my-4" />
				<div class="form-group mb-3 row"><label for="insert10" class="col-md-5 col-form-label"></label>
					<div class="col-md-7"><button class="btn btn-primary btn-lg" type="submit">Insert</button></div>
				</div>
			</form>
			<?php
        //for erorr:
          if(isset($erorr)){
      ?>
          <div style="background-color: #ddd; padding:10px; color:red;">
              <?php echo $erorr; ?>
          </div>  
      <?php  
          }
      ?>
		</div>
	</body>

</html>