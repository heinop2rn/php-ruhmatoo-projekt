<?php

	require("../functions.php");
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
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
	
	if ( isset($_POST["plate"]) && 
		isset($_POST["plate"]) && 
		!empty($_POST["color"]) && 
		!empty($_POST["color"])
	  ) {
		  
		$Car->saveCar($Helper->cleanInput($_POST["plate"]), $Helper->cleanInput($_POST["color"]));
		
	}
	
	//saan kõik auto andmed
	
	//kas otsib
	if(isset($_GET["q"])){
		//kui otsib, võtame otsisõna aadressirealt
		$q = $_GET["q"];
		
	}else{
		//otsisõna on tühi
		$q = "";
		
	}
	
	$sort = "id";
	$orderA = "ASC";
	
	if(isset($_GET["sort"])  && isset($_GET["orderA"])){
		$sort = $_GET["sort"];
		$orderA = $_GET["orderA"];
		
	}
	
	//otsisõna fn sisse
	$carData = $Car->getAllCars($q, $sort, $orderA);
	//echo "<pre>";
	//var_dump($carData);
	//echo "</pre>";
	
	if(isset($_POST["product"]) &&
 			isset($_POST["quantity"]) &&
 			!empty($_POST["product"]) &&
 			!empty($_POST["quantity"])
  		) {
			
			saveOrder($_POST["product"], $_POST["quantity"]);
	}
	
	$people = $Order->AllOrders();
	
	//echo "<pre>";
	//var_dump($people);
	//cho "</pre>";
	
?>
<?php require("../partials/header.php");?>

<p>

	Welcome! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Log out</a>

</p>



<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<h2>Autod</h2>

<form>

	<input type="search" name="q" value="<?=$q;?>">
	<input type="submit" value="Otsi">

</form>
<?php 
	
	$html = "<table class='table table-striped'>";
		
	$html .= "<tr>";
	
		$idOrder =  "ASC";
		$arrow = "&darr;";
		if(isset($_GET["orderA"]) && $_GET["orderA"] == "ASC"){
			$idOrder =  "DESC";
			$arrow = "&uarr;";
		}
		$html .= "<th>
					<a href='?q=".$q."&sort=id&orderA=".$idOrder."'>
						id ".$arrow."
					</a>
				</th>";
		$plateOrder =  "ASC";
		$arrow = "&darr;";
		if(isset($_GET["orderA"]) && $_GET["orderA"] == "ASC"){
			$plateOrder =  "DESC";
			$arrow = "&uarr;";
		}
		$html .= "<th>
					<a href='?q=".$q."&sort=plate&orderA=".$plateOrder."'>
						plate ".$arrow."
					</a>
				</th>";
		$colorOrder =  "ASC";
		$arrow = "&darr;";
		if(isset($_GET["orderA"]) && $_GET["orderA"] == "ASC"){
			$colorOrder =  "DESC";
			$arrow = "&uarr;";
		}
		$html .= "<th>
					<a href='?q=".$q."&sort=color&orderA=".$colorOrder."'>
						color ".$arrow."
					</a>
				</th>";
	$html .= "</tr>";
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		// iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td style='background-color:".$c->carColor."'>".$c->carColor."</td>";
            $html .= "<td><a class='btn btn-default btn-sm' href='edit.php?id=".$c->id."'><span class='glyphicon glyphicon-pencil'></span> Muuda</a></td>";
		$html .= "</tr>";
	}
	
	$html .= "</table>";
	
	echo $html;
	


?>
<?php require("../partials/footer.php");?>
