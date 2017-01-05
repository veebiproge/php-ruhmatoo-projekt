<?php
class Data {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function addAttribute($table, $attribute, $person) {
		
		$allowedTables = ["pplInCourses", "l_o_wOnPpl", "giftsOnPpl", "pplInSmallgroups"];
		if (!in_array($table, $allowedTables)) return;
		
		$stmt = $this->connection->prepare("INSERT INTO $table VALUES (DEFAULT, ?, ?)");
		$stmt->bind_param("ii", $person, $attribute);
		$stmt->execute();
		$stmt->close();
		return;
		
	}
	
	function approve($id) {
		
		$stmt = $this->connection->prepare("UPDATE people SET approved = 1 WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		
	}
	
	function archive($id) {
		
		$stmt = $this->connection->prepare("UPDATE people SET approved = 2 WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		
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
			SELECT person, firstname, lastname FROM (SELECT id, smallgroup, person FROM pplInSmallgroups WHERE smallgroup = $id) AS t1 JOIN (SELECT id, firstname, lastname FROM people) AS t2 ON t1.person=t2.id
		");
		$stmt->bind_result($person, $firstname, $lastname);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->person = $person;
			$result->fname = $firstname;
			$result->lname = $lastname;
			array_push($results, $result);
		}
		
		$stmt->close();
		return $results;
		
	}
	
	function getSmallgroups($index) {
		
		$results = array();
		
		if ($index != "") {
			$stmt = $this->connection->prepare("
				SELECT t1.id, name, address, firstname, lastname, t2.id, email, meetingTime FROM (SELECT * FROM smallgroups WHERE id = ?) AS t1 JOIN (SELECT id, firstname, lastname, email FROM people) AS t2 ON t1.leader=t2.id
			");
			$stmt->bind_param("s", $index);
		} else {
			$stmt = $this->connection->prepare("
				SELECT t1.id, name, address, firstname, lastname, t2.id, email, meetingTime FROM (SELECT * FROM smallgroups) AS t1 JOIN (SELECT id, firstname, lastname, email FROM people) AS t2 ON t1.leader=t2.id
			");
		}
		$stmt->bind_result($id, $name, $address, $leaderFirstname, $leaderLastname, $leaderId, $leaderEmail, $meetingTime);
		$stmt->execute();
		
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->name = $name;
			$result->address = $address;
			$result->leaderFirstname = $leaderFirstname;
			$result->leaderLastname = $leaderLastname;
			$result->leaderId = $leaderId;
			$result->leaderEmail = $leaderEmail;
			$result->meetingTime = $meetingTime;
			array_push($results, $result);
		}
		
		$stmt->close();
		return $results;
		
	}
	
	function removeAttribute ($table, $tableRow, $person, $attribute) {
		
		$allowedTables = ["pplInCourses", "l_o_wOnPpl", "giftsOnPpl", "pplInSmallgroups"];
		$allowedRows = ["smallgroup", "course", "line_of_work", "gift"];
		if (!in_array($table, $allowedTables) OR !in_array($tableRow, $allowedRows)) return;
		
		$stmt = $this->connection->prepare("DELETE FROM $table WHERE person = ? AND $tableRow = ?");
		$stmt->bind_param("ii", $person, $attribute);
		$stmt->execute();
		$stmt->close();
		return;
		
	}
	
	function removeAtt($table, $tableRow, $itemIndex, $attTable) {
		
		$allowedTables = ["pplInCourses", "l_o_wOnPpl", "giftsOnPpl", "pplInSmallgroups"];
		$allowedRows = ["smallgroup", "course", "line_of_work", "gift"];
		$attTables = ["gifts", "line_of_work", "courses"];
		
		if (!in_array($table, $allowedTables) OR !in_array($tableRow, $allowedRows)) return;
		
		$stmt = $this->connection->prepare("DELETE FROM $table WHERE $tableRow = ?");
		$stmt->bind_param("i", $itemIndex);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connection->prepare("DELETE FROM $attTable WHERE id = ?");
		$stmt->bind_param("i", $itemIndex);
		$stmt->execute();
		$stmt->close();
		return;
		
	}
	
	function saveToTableOfTwo($table, $value) {
		
		$allowedTables = ["courses", "line_of_work", "gifts"];
		
		if (!in_array($table, $allowedTables)) {
			return;
		}
		
		$stmt = $this->connection->prepare("INSERT INTO $table VALUES (DEFAULT, ?)");
		$stmt->bind_param("s", $value);
		$stmt->execute();
		$stmt->close();
		return;
	}
	
	function saveSmallgroup($name, $address, $leader, $meetingTime) {
		
		$stmt = $this->connection->prepare("INSERT INTO smallgroups VALUES (DEFAULT, ?, ?, ?, ?)");
		$stmt->bind_param("ssis", $name, $address, $leader, $meetingTime);
		$stmt->execute();
		$stmt->close();
		return;
	}
	
	function updateSmallgroup($index, $leader, $address) {
		
		$stmt = $this->connection->prepare("UPDATE smallgroups SET leader = ?, address = ? WHERE id = ?");
		$stmt->bind_param("isi", $leader, $address, $index);
		$stmt->execute();
		$stmt->close();
		return;
	}
	
	function delSmallgroup ($id) {
		
		$stmt = $this->connection->prepare("DELETE FROM pplInSmallgroups WHERE smallgroup = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		
		$stmt = $this->connection->prepare("DELETE FROM smallgroups WHERE id = ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
		return;
		
	}
	
}
?>