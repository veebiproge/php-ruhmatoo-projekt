<?php
class Data {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getFromTableOfTwo($table) {
		
		$results = array();
		$allowedTables = ["smallgroups", "course", "line_of_work"];
		
		$stmt = $this->connection->prepare("SELECT * FROM $table");
		$stmt->bind_result($id, $data);
		
		while($stmt->execute()) {
			$result = new StdClass();
			$result->id = $id;
			//echo $data;
			$result->data = $data;
			array_push($results, $result);
		}
		
		$stmt->close();
		return $results;
		
	}
	
}
?>