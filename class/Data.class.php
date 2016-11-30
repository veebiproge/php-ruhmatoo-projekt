<?php
class Data {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getAllPpl() {
		$results = array();
		$stmt = $this->connection->prepare("SELECT firstname, lastname, email, date_of_birth, saved, baptised FROM people");
		$stmt->bind_result($fname, $lname, $email, $dob, $saved, $baptised);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->fname = $fname;
			$result->lname = $lname;
			$result->email = $email;
			$result->dob = $dob;
			$result->saved = $saved;
			$result->baptised = $baptised;
			array_push($results, $result);
		}
		return $results;
		$stmt->close();
	}
	
	function search($searchValue, $searchOption) {
		
		$allowedSearch = ["firstname", "lastname", "email", "date_of_birth", "saved", "baptised"];
		if(!in_array($searchOption, $allowedSearch)) {
			$searchOption = "firstname";
		}
		$results = array();
		$stmt = $this->connection->prepare("
			SELECT firstname, lastname, email, date_of_birth, saved, baptised
			FROM people WHERE $searchOption LIKE ?
		");
		$searchValue = '%'.$searchValue.'%';
		$stmt->bind_param("s", $searchValue);
		$stmt->bind_result($fname, $lname, $email, $dob, $saved, $baptised);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->fname = $fname;
			$result->lname = $lname;
			$result->email = $email;
			$result->dob = $dob;
			$result->saved = $saved;
			$result->baptised = $baptised;
			array_push($results, $result);
		}
		return $results;
		$stmt->close();
	}
	
}
?>