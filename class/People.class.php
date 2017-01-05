<?php
class People {
	
	private $connection;
	
	function __construct($link) {
		$this->connection = $link;
	}
	
	function getPpl($searchValue, $searchOption, $sort, $order) {
		$allowedSearch = ["approved", "firstname", "lastname", "email", "date_of_birth", "saved", "baptised", "line_of_work", "phonenumber", "smallgroups", "courses"];
		$allowedSort = ["approved", "firstname", "lastname", "email", "date_of_birth", "saved", "baptised", "line_of_work", "phonenumber", "smallgroups", "courses"];
		
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
			SELECT t1.id, approved, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised, line_of_work, gift, course, smallgroup, sgName  FROM
			(SELECT id, approved, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised FROM people) AS t1
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
			LEFT JOIN
			(SELECT GROUP_CONCAT(name) AS sgName, leader FROM smallgroups GROUP BY leader) AS t6 ON t1.id=t6.leader
			WHERE $searchOption LIKE ? ORDER BY $sort $order
		");
		$searchValue = '%'.$searchValue.'%';
		$stmt->bind_param("s", $searchValue);
		$stmt->bind_result($id, $app, $fname, $lname, $email, $phonenumber, $dob, $saved, $baptised, $line_of_work, $gift, $course, $smallgroup, $sgLeader);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->app = $app;
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
			$result->sgLeader = $sgLeader;
			array_push($results, $result);
		}
		$stmt->close();
		return $results;
		
	}
	
	function getPerson ($index) {
		
		$results = array();
		$stmt = $this->connection->prepare("
			SELECT id, approved, firstname, lastname, email, phonenumber, date_of_birth, saved, baptised FROM people WHERE id = $index
		");
		$stmt->bind_result($id, $app, $fname, $lname, $email, $phonenumber, $dob, $saved, $baptised);
		$stmt->execute();
		while ($stmt->fetch()) {
			$result = new Stdclass();
			$result->id = $id;
			$result->app = $app;
			$result->fname = $fname;
			$result->lname = $lname;
			$result->email = $email;
			$result->phonenumber = $phonenumber;
			$result->dob = $dob;
			$result->saved = $saved;
			$result->baptised = $baptised;
			$result->line_of_work = array();
			$result->gift = array();
			$result->course = array();
			$result->smallgroup = array();
			$result->smallgroupToLead = array();
			array_push($results, $result);
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT line_of_work.id, line_of_work.line_of_work FROM l_o_wOnPpl JOIN line_of_work ON l_o_wOnPpl.line_of_work=line_of_work.id WHERE l_o_wOnPpl.person = $index");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()) {
			$att = new Stdclass();
			$att->id = $id;
			$att->name = $name;
			array_push($result->line_of_work, $att);
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT gifts.id, gifts.gift FROM giftsOnPpl JOIN gifts ON giftsOnPpl.gift=gifts.id WHERE giftsOnPpl.person = $index");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()) {
			$att = new Stdclass();
			$att->id = $id;
			$att->name = $name;
			array_push($result->gift, $att);
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT courses.id, courses.course FROM pplInCourses JOIN courses ON pplInCourses.course=courses.id WHERE pplInCourses.person = $index");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()) {
			$att = new Stdclass();
			$att->id = $id;
			$att->name = $name;
			array_push($result->course, $att);
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT smallgroups.id, smallgroups.name FROM pplInSmallgroups JOIN smallgroups ON smallgroups.id=pplInSmallgroups.smallgroup WHERE pplInSmallgroups.person = $index");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()) {
			$att = new Stdclass();
			$att->id = $id;
			$att->name = $name;
			array_push($result->smallgroup, $att);
		}
		$stmt->close();
		
		$stmt = $this->connection->prepare("SELECT smallgroups.id, smallgroups.name FROM smallgroups WHERE leader = $index");
		$stmt->bind_result($id, $name);
		$stmt->execute();
		while($stmt->fetch()) {
			$att = new Stdclass();
			$att->id = $id;
			$att->name = $name;
			array_push($result->smallgroupToLead, $att);
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
	
	function updatePerson($index, $field, $value) {
		
		$allowedField = ["firstname", "lastname", "email", "saved", "baptised", "phonenumber"];
		if (!in_array($field, $allowedField)) return;
		
		$stmt = $this->connection->prepare("UPDATE people SET $field = ? WHERE id = ?");
		$stmt->bind_param("si",  $value, $index);
		$stmt->execute();
		$stmt->close();
		
	}
	
}
?>