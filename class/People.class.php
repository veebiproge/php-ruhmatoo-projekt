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
			SELECT * FROM
			(SELECT id, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised FROM people) AS t1
			JOIN
			(SELECT person, GROUP_CONCAT(line_of_work.line_of_work) AS line_of_work FROM l_o_wOnPpl 
			JOIN 
			line_of_work ON l_o_wOnPpl.line_of_work=line_of_work.id GROUP BY person) AS t2 ON t1.id=t2.person
			WHERE $searchOption LIKE ? ORDER BY $sort $order
		");
		$searchValue = '%'.$searchValue.'%';
		$stmt->bind_param("s", $searchValue);
		$stmt->bind_result($id, $fname, $lname, $email, $phonenumber, $dob, $saved, $baptised, $id, $line_of_work);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->fname = $fname;
			$result->lname = $lname;
			$result->email = $email;
			$result->phonenumber = $phonenumber;
			$result->dob = $dob;
			$result->saved = $saved;
			$result->baptised = $baptised;
			$result->line_of_work = $line_of_work;
			array_push($results, $result);
		}
		$stmt->close();
		return $results;
		
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