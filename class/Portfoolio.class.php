<?php

class Portfoolio {
	
	private $connection;
	
	
	function __construct ($mysqli) {
		
		$this->connection = $mysqli;
		
		function savePortfolio ($facebooki_leht, $blogi, $portfoolio, $kirjeldus){
		
			$database = "if16_sirjemaria";
			$this->connection = new $this->connection($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
			$stmt = $this->connection->prepare("INSERT INTO users (facebooki_leht, blogi, portfoolio, kirjeldus) VALUES (?, ?, ?, ?)");
			echo $this->connection->error;
		
			$stmt->bind_param("ssss", $facebooki_leht, $blogi, $portfoolio, $kirjeldus);
		
			if ($stmt->execute()) {
				echo "Saved!";
			} else {
				echo "ERROR".$stmt->error;
	   }
	   
		$stmt->close();
		$this->connection->close();
		}
	}
}

	
	
	
	
	
	
	
?>