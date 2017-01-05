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
	function login ($loginId, $password) {
		
		$error = "";

		$stmt = $this->connection->prepare("
		SELECT id, username, password, rights
		FROM people
		WHERE username = ? OR email = ?");
	
		echo $this->connection->error;
		
		//asendan küsimärgi
		$stmt->bind_param("ss", $loginId, $loginId);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $usernameFromDb, $passwordFromDb, $rights);
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
				$_SESSION["rights"] = $rights;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: profile.php?id=".$_SESSION["userId"]);
				exit();
				
			}else {
				$error = "Sisse logimise andmed pole õiged, proovi uuesti!";
			}
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "Sisse logimise andmed pole õiged, proovi uuesti!";
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
	
}
?>