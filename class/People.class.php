<?php
class People {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getPpl($searchValue, $searchOption, $sort, $order) {
		$allowedSearch = ["firstname", "lastname", "email", "date_of_birth", "saved", "baptised"];
		$allowedSort = ["firstname", "lastname", "email", "date_of_birth", "saved", "baptised"];
		
		if(!in_array($searchOption, $allowedSearch)) {
			$searchOption = "id";
		}
		
		if(!in_array($sort, $allowedSort)) {
			$sort = "id";
		}
		
		if ($order == "DESC") {
			$order = "DESC";
		} else {
			$order = "ASC";
		}
		
		$results = array();
		$stmt = $this->connection->prepare("
			SELECT firstname, lastname, email, date_of_birth, saved, baptised
			FROM people WHERE $searchOption LIKE ? ORDER BY $sort $order
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
	
	function sortResults ($sort, $tableHeader, $search, $searchBy) {
		$itemOrder = "ASC";
		$itemArrow = "";
		
		if (isset($_GET["order"]) && $_GET["order"] == "ASC" && isset($_GET["sort"]) && $_GET["sort"] == $sort ) {
				$itemOrder = "DESC";
				$itemArrow = "&uarr;";
			} elseif (isset($_GET['sort']) && $_GET['sort'] == $sort) {
				$itemArrow = "&darr;";
			}
		$resultTbl = "<th style = 'text-align:center'> 
			<a href = '?search=".$search."&searchBy=".$searchBy."&sort=".$sort."&order=".$itemOrder."'> ".$tableHeader.$itemArrow." </a>
		</th>";
		
		return $resultTbl;
	}
	
}
?>