<?php
class User {
	
	// klassi sees saab kasutada
	private $connection;
	
	// $User = new User(see); jõuab siia sulgudesse
	function __construct($link){
		
		// klassi sees muutuja kasutamseks $this->
		// $this viitab sellele klassile
		$this->connection = $link;
		
		
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
	
	
	function signUp ($email, $password, $username, $firstname, $lastname, $phoneNumber, $dateOfBirth, $saved, $baptised) {
		

		$stmt = $this->connection->prepare("INSERT INTO people (email, password, username, firstname, lastname, phonenumber, date_of_birth, saved, baptised) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
	
		echo $this->connection->error;
		
		$stmt->bind_param("sssssisss", $email, $password, $username, $firstname, $lastname, $phoneNumber, $dateOfBirth, $saved, $baptised);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
			header("Location: login.php");
			exit();
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();		
	}
	
	function addEmpties($email) {
		
		$stmt = $this->connection->prepare("SELECT id, username FROM people WHERE email = ?");
		echo $this->connection->error;
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$indexOfPerson = $stmt->insert_id;
		$stmt->close();
		
		$stmt = $this->connection->prepare("INSERT INTO l_o_wOnPpl VALUES (DEFAULT, $indexOfPerson, DEFAULT)");
		echo $this->connection->error;
		$stmt->execute();
		$stmt->close();
		
	}
	
	
}
?>