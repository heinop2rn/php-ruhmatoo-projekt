<?php

	require("../functions.php");
	
	
	require("../class/Portfoolio.class.php");
	$Portfoolio = new Portfoolio($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	$PictureError = "";
	
	//Kas on sisse loginud, kui ei ole siis
	//suunata login lehele
	if (!isset($_SESSION["userId"])) {
		
		//header("Location: login.php");
		//exit();
	}

	//kas ?logout on aadressireal
	if (isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	if(isset($_POST["facebooki_leht"]) &&
 			isset($_POST["blogi"]) &&
			isset($_POST["portfoolio"]) &&
			isset($_POST["kirjeldus"]) &&
 			!empty($_POST["facebooki_leht"]) &&
			!empty($_POST["blogi"]) &&
			!empty($_POST["portfoolio"]) &&
 			!empty($_POST["kirjeldus"])
  		) {
			
			$Portfoolio->savePortfolio($Helper->cleanInput($_POST["facebooki_leht"]), $Helper->cleanInput($_POST["blogi"]), $Helper->cleanInput($_POST["portfoolio"]), $Helper->cleanInput($_POST["kirjeldus"]));
	}
	
	
if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["name"])){
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            
            // save file name to DB here
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}else{
    echo "Please select the file that you want to upload!";
}
?>
<?php require("../partials/header.php");?>

<p>

	Loo portfoolio! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Logi välja</a>

</p>

<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			<form method="POST">
			<br><br>
			<div class="form-group">
				<input class="form-control" type="text" name="Fbaddress" placeholder="Facebooki leht">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="Blogaddress" placeholder="Blogi">
			</div>
			<div class="form-group">
				<input class="form-control" type="text" name="Portfoolioaddress" placeholder="Portfoolio link">
			<br>
			<form action="demo_form.asp" id="usrform">
			<textarea name="comment" form="usrform" rows="5" cols="35">Kirjelda ennast...</textarea>
			<input type="submit" value="Lisa info">
			</div>
		</div>
	</div>
	</div>
</body>
</html>
</form>
</form>
<!DOCTYPE html>
<html>
<body>
<div class="container">
		<div class="row">
			<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			<form action="upload.php" method="post" enctype="multipart/form-data">
			Sisesta portfoolio pildid:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
		</div>
	</div>
</form>

</body>
</html>

<h2>Profiil</h2>

<?php 

	


?>
<?php require("../partials/footer.php");?>
