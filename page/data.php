<?php
	
	require_once("../functions.php");
	
	require_once("../class/People.class.php");
	$People = new People($link);
	
	require_once("../class/Helper.class.php");
	$Helper = new Helper();
	
	if (!isset($_SESSION["userId"])){
		
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if (isset($_GET["search"])) {
		$search = $Helper->cleanInput($_GET["search"]);
	} else {
		$search = "";
	}
	
	if(isset($_GET["searchBy"])) {
		$searchBy = $Helper->cleanInput($_GET["searchBy"]);
	} else {
		$searchBy = "id";
	}
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $Helper->cleanInput($_GET["sort"]);
		$order = $Helper->cleanInput($_GET["order"]);
	} else {
		$sort = "id";
		$order = "ASC";
	}
	
	$results = $People->getPpl($search, $searchBy, $sort, $order);
	
?>
<?php require("../partials/loggedInHeader.php"); ?>

<form>
	Otsing:	
	<input type = "text" name = "search">
	<select name = "searchBy">
		<option value = "firstname"> Eesnimi </option>
		<option value = "lastname"> Perenimi </option>
		<option value = "email"> Email </option>
		<option value = "phonenumber"> Telefoninumber </option>
		<option value = "line_of_work"> Tööharu </option>
		<option value = "date_of_birth"> Sünnikuupäev </option>
		<option value = "saved"> Päästetud </option>
		<option value = "baptised"> Ristitud </option>
	</select>
	<input type = "submit" value = "Otsi"><br><br>
</form>

<?php

	$resultTbl = "<table class = 'table'>";
		$resultTbl .= "<tr border='2'>";
		
			$resultToTbl = $People->sortResults("firstname", "Eesnimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("lastname", "Perenimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("email", "Email", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("phonenumber", "Telefoninumber", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("line_of_work", "Tööharu", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("gift", "Oskused", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("course", "Kursused", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("smallgroup", "Väikegrupid(osaleja)", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("sgLeader", "Väikegrupid(juht)", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("date_of_birth", "Sünnikuupäev", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("saved", "Päästetud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("baptised", "Ristitud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			if ($_SESSION["rights"] > 4) {
				$resultTbl .= "<th></th>";
			}
			
		$resultTbl .= "</tr>";
		
		foreach($results as $r) {
			$resultTbl .= "<tr>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->fname."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->lname."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->email."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->phonenumber."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->line_of_work."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->gift."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->course."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->smallgroup."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->sgLeader."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->dob."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->saved."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->baptised."</td>";
			if ($_SESSION["rights"] > 4) {
				$resultTbl .= "<td style = 'text-align:center' width = '100'> <a class='btn btn-default btn-sm' href = 'profile.php?id=".$r->id."'>Vaata</a> </td>";
			}
		$resultTbl .= "</tr>";
		}
		
	echo $resultTbl
?>

<?php require("../partials/footer.php"); ?>