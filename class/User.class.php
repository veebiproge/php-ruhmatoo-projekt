<?php
class User {
	
	// klassi sees saab kasutada
	private $connection;
	
	// $User = new User(see); jõuab siia sulgudesse
	function __construct($mysqli){
		
		// klassi sees muutuja kasutamseks $this->
		// $this viitab sellele klassile
		$this->connection = $mysqli;
		
		
	}
	
	//Teised funktsioonid
	
	function login ($username, $password) {
		
		$error = "";

		$stmt = $this->connection->prepare("
		SELECT id, username, password
		FROM people
		WHERE username = ?");
	
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $username);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $usernameFromDb, $passwordFromDb);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "Kasutaja logis sisse ".$id;
				
				//määran sessiooni muutujad, millele saan ligi
				// teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userUsername"] = $usernameFromDb;
				
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
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		
		//muidu katkeb ühendus tervele klassile
		//$mysqli->close();
		
	}
	
	
	
}
?>