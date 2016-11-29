<?php
class User {
	
	// klassi sees saab kasutada
	private $connection;
	
	// $User = new User(see); jıuab siia sulgudesse
	function __construct($mysqli){
		
		// klassi sees muutuja kasutamseks $this->
		// $this viitab sellele klassile
		$this->connection = $mysqli;
		
		
	}
	
	//Teised funktsioonid
	
	function login ($email, $password) {
		
		$error = "";

		$stmt = $this->connection->prepare("
		SELECT id, email, password
		FROM people
		WHERE email = ?");
	
		echo $this->connection->error;
		
		//asendan k¸sim‰rgi
		$stmt->bind_param("s", $email);
		
		//m‰‰ran v‰‰rtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//andmed tulid andmebaasist vıi mitte
		// on tıene kui on v‰hemalt ¸ks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//m‰‰ran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				exit();
				
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
		
	}
	
	
	function signUp ($username, $password, $email, $firstname, $lastname, $gender) {
		

		$stmt = $this->connection->prepare("INSERT INTO people (username, password, email, firstname, lastname, gender) VALUES (?, ?, ?, ?, ?, ?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("ssssss", $username, $password, $email, $firstname, $lastname, $gender);
		
		if($stmt->execute()) {
			echo "salvestamine √µnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
		//muidu katkeb ¸hendus tervele klassile
		//$mysqli->close();
		
	}
	
	
	
}
?>