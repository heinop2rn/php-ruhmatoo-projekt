<?php

	require("../functions.php");
	
	
	require("../class/Portfoolio.class.php");
	$Portfoolio = new Portfoolio($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	require("../class/User.class.php");
	
	$PictureError = "";
	
	//Kas on sisse loginud, kui ei ole siis
	//suunata login lehele
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
		exit();
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
			<div class="form-group">
			<textarea rows="4" cols="34">Kirjelda ennast...</textarea>
			<br>
			<br>
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Lisa info">
			</div>
		</div>
	</div>
</div>
<?php require("../partials/footer.php");?>
