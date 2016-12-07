<?php

	require("../functions.php");
	
	require("../class/Car.Class.php");
	$Car = new Car($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	require("../class/Order.Class.php");
	$Order = new Order($mysqli);
	
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
	
	
	
?>
<?php require("../partials/header.php");?>

<p>

	Tere! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Logi välja</a>

</p>



<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<h2>Profiil</h2>

<?php 

	


?>
<?php require("../partials/footer.php");?>
