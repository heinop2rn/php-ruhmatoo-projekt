<?php

class Portfoolio {
	
	private $connection;
	
	
	function __construct ($mysqli) {
		
		$this->connection = $mysqli;
		
		function savePortfolio ($id, $facebooki_leht, $blogi, $portfoolio, $kirjeldus){
		
			$database = "if16_sirjemaria";
			$this->connection = new $this->connection($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		
			$stmt = $this->connection->prepare("UPDATE users SET facebooki_leht=?, blogi=?, portfoolio=?, kirjeldus=? WHERE id=?");
			echo $this->connection->error;
		
			$stmt->bind_param("ssssi", $facebooki_leht, $blogi, $portfoolio, $kirjeldus, $id);
		
			if ($stmt->execute()) {
				echo "Salvestamine õnnestus!";
			} else {
				echo "ERROR".$stmt->error;
	   }
	   
		$stmt->close();
		$this->connection->close();
		}
	}
}

	
	
	
	
	
	
	
?>