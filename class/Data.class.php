<?php
class Data {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getFromTableOfTwo($table) {
		
		$results = array();
		$allowedTables = ["smallgroups", "course", "line_of_work"];
		
		if (!in_array($table, $allowedTables)) {
			$result = new Stdclass();
			$result->id = "Õigused";
			$result->data = "Puuduvad";
			array_push($results, $result);
			return $results;
		}
		
		$stmt = $this->connection->prepare("SELECT * FROM $table");
		$stmt->bind_result($id, $data);
		echo $stmt->error;
		$stmt->execute();
		
		while($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->data = $data;
			array_push($results, $result);
		}
		
		$stmt->close();
		return $results;
		
	}
	
	function save ($table, $value) {
		
		$allowedTables = ["course", "line_of_work", "smallgroups"];
		
		if (!in_array($table, $allowedTables)) {
			return;
		}
		
		$stmt = $this->connection->prepare("INSERT INTO $table VALUES (DEFAULT, ?)");
		$stmt->bind_param("s", $value);
		$stmt->execute();
		/*
		if ($stmt->execute()) {
			echo "Salvestamine õnnestus";
		} else {
			echo "Viga";
		}*/
		return;
	}
	
}
?>