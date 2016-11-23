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
<h1>Place an order!</h1>
<p>

	Welcome! <a href="user.php"><?=$_SESSION["userEmail"];?> -</a>
	<a href="?logout=1">Log out</a>

</p>

<form method="POST">

		<label>Product</label>
		<br>
		<input name="product" type="text">
		<br>
		<br>
		<label>Quantity</label>
		<br>
		<input name="quantity" type="text">
		<br>
		<br>
		
		<input type="submit" value="Add to cart">
		

			
</form>

<h2>Ordered products:</h2>
<?php

	$html = "<table>";
	
			$html .="<tr>";
				$html .= "<th>id</th>";
				$html .= "<th>product</th>";
				$html .= "<th>quantity</th>";
				$html .= "<th>created</th>";
				
			$html .="</tr>";
	
		foreach($people as $p) {
			$html .="<tr>";
				$html .= "<td>".$p->id."</td>";
				$html .= "<td>".$p->product."</td>";
				$html .= "<td>".$p->quantity."</td>";
				$html .= "<td>".$p->created."</td>";
			$html .="</tr>";
		}
		
$html .= "</table>";
	
	echo $html;
	
	
	$listHtml = "<br><br>";
	
	foreach($people as $p){
		
		
		$html .= "<h1>".$p->product."</h1>";
		$html .= "<td>".$p->quantity."</td>";
		$html .= "<td>".$p->created."</td>";
	}
	
	echo $listHtml;
?>
<h2>Salvesta auto</h2>
<form method="POST">
	
	<label>Auto nr</label><br>
	<input name="plate" type="text">
	<br><br>
	
	<label>Auto värv</label><br>
	<input type="color" name="color" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
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
	
	
	$listHtml = "<br><br>";
	
	foreach($carData as $c){
		
		
		$listHtml .= "<h1 style='color:".$c->carColor."'>".$c->plate."</h1>";
		$listHtml .= "<p>color = ".$c->carColor."</p>";
	}
	
	echo $listHtml;

?>
<?php require("../partials/footer.php");?>
