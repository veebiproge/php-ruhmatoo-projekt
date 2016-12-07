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
			SELECT id, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised
			FROM people WHERE $searchOption LIKE ? ORDER BY $sort $order
		");
		$searchValue = '%'.$searchValue.'%';
		$stmt->bind_param("s", $searchValue);
		$stmt->bind_result($id, $fname, $lname, $email, $phonenumber, $dob, $saved, $baptised);
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
			$result->line_of_work = array();
			array_push($results, $result);
		}
		$stmt->close();
		
		foreach($results as $user){
			$lowStmt = $this->connection->prepare("
				SELECT line_of_work, person FROM l_o_wOnPpl WHERE person = ".$user->id."
			");
			$lowStmt->bind_result($line_of_work, $person);
			$lowStmt->execute();
			while ($lowStmt->fetch()) {
				array_push($user->line_of_work, $line_of_work);
			}
			
			$lowStmt->close();
		}
				
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