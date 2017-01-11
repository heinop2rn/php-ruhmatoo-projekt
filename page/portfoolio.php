<?php

	require("../functions.php");
	
	require("../class/Portfoolio.class.php");
	$Portfoolio = new Portfoolio($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	$PictureError = "";
	
	//Kas on sisse loginud, kui ei ole siis
	//suunata login lehele
	//kommentaar
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
	
	
	if(isset($_POST["insert"]))  {
		if ( empty ( $_POST["insert"] ) ) {
			$Portfoolio->savePortfolio($Helper->cleanInput($_POST["facebooki_leht"]), $Helper->cleanInput($_POST["blogi"]), $Helper->cleanInput($_POST["portfoolio"]), $Helper->cleanInput($_POST["kirjeldus"]));
	}
	
?>
<?php require("../partials/header.php");?>

			Loo portfoolio! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
			<a href="?logout=1">Logi välja</a>

<form method="POST">

	´<div class="container">
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
			<form action="demo_form.asp" id="usrform">
			<textarea name="comment" form="usrform" rows="5" cols="35" placeholder="BIO - Fotograafi kirjeldus"></textarea>
			<br>
			<br>
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Lisa info">
			</div>
			</div>
			</div>
		</div>
</html>
<?php require("../partials/footer.php");?>