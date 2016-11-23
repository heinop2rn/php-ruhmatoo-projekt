<?php
class Order {
	
	private $connection;
	
	
	function __construct ($mysqli) {
		
		$this->connection = $mysqli;
	
	}
		
	/* TEISED FUNKTSIOONID  */
	
	function AllOrders() {
		
		$database = "if16_sirjemaria";
		$mysqli = new $this->connection($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $this->connection->prepare("
			SELECT id, product, quantity,
			created FROM placeAnOrder
		");
		echo $this->connection->error;
		
		$stmt->bind_result($id, $product, $quantity, $created);
		$stmt->execute();
		
		
		// array("SML","mhm")
		$result = array();
		
		//seni kuni on 1 rida andmeid saata ehk 10 rida=10 korda
		while ($stmt->fetch()) {
			
			$person = new StdClass();
			$person->id = $id;
			$person->product = $product;
			$person->quantity = $quantity;
			$person->created = $created;
				
			//echo $color."<br>";
			array_push($result, $person);
			
		}
		
		$stmt->close();
		$this->connection->close();
		
		return $result;
		
	}
	
	function saveOrder ($product, $quantity){
		
		$database = "if16_sirjemaria";
		$this->connection = new $this->connection($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
		$stmt = $this->connection->prepare("INSERT INTO placeAnOrder (product, quantity) VALUES (?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("ss", $product, $quantity);
		
		if ($stmt->execute()) {
			echo "Saved!";
	   } else {
			echo "ERROR".$stmt->error;
	   }
	   
	   $stmt->close();
		$this->connection->close();
	}

}


?>