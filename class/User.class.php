<?php
class User {
	
	//klassi sees saab kasutada
	private $connection;
	
	
	// $User= new User(see); j�uab siia sulgude vahele
	function __construct ($mysqli) {
		
		//klassi sees muutuja kasutamiseks $this->
		$this->connection = $mysqli;
		
		
	}
	
	/* TEISED FUNKTSIOONID  */
	
	function login ($email, $password){
		
		$error = "";
		
		$this->connection = new $this->connection($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
		
			$stmt = $this->connection->prepare("
			SELECT id, parool, nimi, epost, staatus
			FROM users
			WHERE epost = ?");
			
		echo $this->connection->error;
		
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email);
		
		//m��ran tulpadele muutujad
		$stmt->bind_result($id, $passwordFromDb, $name, $emailFromDb, $staatus);
		$stmt->execute();
		
		//k�sin rea andmeid
		if($stmt->fetch()){
				//oli rida
				
				//v�rdlen paroole
				$hash = hash("sha512", $password);
				if($hash == $passwordFromDb){
					
					echo "User logged in ".$id;
					
					$_SESSION["userId"] = $id;
					$_SESSION["userEmail"] = $emailFromDb;
					
					$_SESSION["message"] = "<h1>Welcome!</h1>";
					
					//suunaks uuele lehele
					header("Location: data.php");
					
				} else {
					$error = "Wrong password!";
				}
						
		} else {
			//ei olnud
			
			$error = "Wrong email!";
			
			
		}		
		
		return $error;
	
	}	
	
	function signUp ($password, $signupName, $signupEmail, $staatus){
		
		
		$this->connection = new $this->connection($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $this->connection->prepare("INSERT INTO users (parool, nimi, epost, staatus) VALUES (?, ?, ?, ?)");
		echo $this->connection->error;
		
		$stmt->bind_param("ssss", $password, $signupName, $signupEmail, $staatus);
		
		if ($stmt->execute()) {
			echo "Saved!";
	   } else {
		   echo "ERROR ".$stmt->error;
	   }
	   
		$stmt->close();
		$this->connection->close();
	   
		
	}	
	
	
	
}




?>