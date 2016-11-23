<?php
	//edit.php
	require("../functions.php");
	
	require("../class/editFunctions.php");
	
	require("../class/Car.Class.php");
	$Car = new Car($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	if(isset($_GET["delete"])&&isset($_GET["id"])) {
		deleteCar($Helper->cleanInput($_GET["id"]));
		header("Location: data.php");
		exit();
	}
	
	//kas kasutaja uuendab andmeid
	if(isset($_POST["update"])){
		
		updateCar($Helper->cleanInput($_POST["id"]),$Helper->cleanInput ($_POST["plate"]),$Helper->cleanInput($_POST["color"]));
		
		header("Location: edit.php?id=".$_POST["id"]."&success=true");
        exit();	
		
	}
	
	//saadan kaasa id
	$c = getSingleCarData($_GET["id"]);
	var_dump($c);
	
?>
<?php require("../partials/header.php");?>
<br><br>
<a href="data.php"> tagasi </a>

<h2>Muuda kirjet</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<input type="hidden" name="id" value="<?=$_GET["id"];?>" > 
  	<label for="number_plate" >auto nr</label><br>
	<input id="number_plate" name="plate" type="text" value="<?php echo $c->plate;?>" ><br><br>
  	<label for="color" >värv</label><br>
	<input id="color" name="color" type="color" value="<?=$c->color;?>"><br><br>
  	
	<input type="submit" name="update" value="Salvesta">
  </form>
  
  <br>
  <br>
  
  <a href="?id=<?=$_GET["id"];?>&delete=true">Kustuta</a>
  <?php require("../partials/footer.php");?>