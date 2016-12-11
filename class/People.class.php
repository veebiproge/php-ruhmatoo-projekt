<?php
class People {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getPpl($searchValue, $searchOption, $sort, $order) {
		$allowedSearch = ["firstname", "lastname", "email", "date_of_birth", "saved", "baptised", "line_of_work", "phonenumber", "smallgroups", "courses"];
		$allowedSort = ["firstname", "lastname", "email", "date_of_birth", "saved", "baptised", "line_of_work", "phonenumber", "smallgroups", "courses"];
		
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
			SELECT t1.id, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised, line_of_work, gift, course, smallgroup  FROM
			(SELECT id, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised FROM people) AS t1
			LEFT JOIN
			(SELECT person, GROUP_CONCAT(line_of_work.line_of_work) AS line_of_work FROM l_o_wOnPpl 
			JOIN 
			line_of_work ON l_o_wOnPpl.line_of_work=line_of_work.id GROUP BY person) AS t2 ON t1.id=t2.person
			LEFT JOIN
			(SELECT person, GROUP_CONCAT(gifts.gift) AS gift FROM giftsOnPpl 
			JOIN 
			gifts ON giftsOnPpl.gift=gifts.id GROUP BY person) AS t3 ON t1.id=t3.person
			LEFT JOIN
			(SELECT person, GROUP_CONCAT(courses.course) AS course FROM pplInCourses 
			JOIN 
			courses ON pplInCourses.course=courses.id GROUP BY person) AS t4 ON t1.id=t4.person
			LEFT JOIN
			(SELECT person, GROUP_CONCAT(smallgroups.name) AS smallgroup FROM pplInSmallgroups 
			JOIN 
			smallgroups ON pplInSmallgroups.smallgroup=smallgroups.id GROUP BY person) AS t5 ON t1.id=t5.person
			WHERE $searchOption LIKE ? ORDER BY $sort $order
		");
		$searchValue = '%'.$searchValue.'%';
		$stmt->bind_param("s", $searchValue);
		$stmt->bind_result($id, $fname, $lname, $email, $phonenumber, $dob, $saved, $baptised, $line_of_work, $gift, $course, $smallgroup);
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
			$result->gift = $gift;
			$result->course = $course;
			$result->smallgroup = $smallgroup;
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