<?php
class Data {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getFromTableOfTwo($table) {
		
		$results = array();
		$allowedTables = ["courses", "line_of_work", "gifts"];
		
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
	
	function getPplInSmallgroup($id) {
		
		$results = array();
		$stmt = $this->connection->prepare("
			SELECT firstname, lastname FROM (SELECT id, smallgroup, person FROM `pplInSmallgroups` WHERE smallgroup = $id) AS t1 JOIN (SELECT id, firstname, lastname FROM people) AS t2 ON t1.person=t2.id
		");
		$stmt->bind_result($firstname, $lastname);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->fname = $firstname;
			$result->lname = $lastname;
			array_push($results, $result);
		}
		
		return $results;
		
	}
	
	function getSmallgroups($index) {
		
		$results = array();
		$index = "%".$index."%";
		
		$stmt = $this->connection->prepare("
			SELECT t1.id, name, address, firstname, t2.id FROM (SELECT * FROM smallgroups WHERE id LIKE ?) AS t1 JOIN (SELECT id, firstname FROM people) AS t2 ON t1.leader=t2.id
		");
		$stmt->bind_param("s", $index);
		$stmt->bind_result($id, $name, $address, $leader, $leaderId);
		$stmt->execute();
		
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->name = $name;
			$result->address = $address;
			$result->leader = $leader;
			$result->leaderId = $leaderId;
			array_push($results, $result);
		}
		
		return $results;
		
	}
	
	function saveToTableOfTwo($table, $value) {
		
		$allowedTables = ["courses", "line_of_work", "gifts"];
		
		if (!in_array($table, $allowedTables)) {
			return;
		}
		
		$stmt = $this->connection->prepare("INSERT INTO $table VALUES (DEFAULT, ?)");
		$stmt->bind_param("s", $value);
		$stmt->execute();
		return;
	}
	
	function saveSmallgroup($name, $address, $leader) {
		
		$stmt = $this->connection->prepare("INSERT INTO smallgroups VALUES (DEFAULT, ?, ?, ?)");
		$stmt->bind_param("ssi", $name, $address, $leader);
		$stmt->execute();
		return;
	}
	
	function updateSmallgroup($index, $leader, $address) {
		
		$stmt = $this->connection->prepare("UPDATE smallgroups SET leader = ?, address = ? WHERE id = ?");
		$stmt->bind_param("isi", $leader, $address, $index);
		$stmt->execute();
	}
	
}
?>