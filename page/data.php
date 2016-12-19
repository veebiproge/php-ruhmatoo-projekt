<?php
	
	require_once("../functions.php");
	
	require_once("../class/People.class.php");
	$People = new People($link);
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
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
	
	$lines_of_work = $Data->getFromTableOfTwo("line_of_work");
	$gifts = $Data->getFromTableOfTwo("gifts");
	$courses = $Data->getFromTableOfTwo("courses");
	$smallgroups = $Data->getSmallgroups("");
	$results = $People->getPpl($search, $searchBy, $sort, $order);
	
	foreach($results as $r) {
		if (isset($_POST['lowToJoin']) && isset($_POST["addLow".$r->id])) {
			$Data->addAttribute("l_o_wOnPpl", $_POST['lowToJoin'], $r->id);
		}
	}
	
	foreach($results as $r) {
		if (isset($_POST['gToJoin']) && isset($_POST["addG".$r->id])) {
			$Data->addAttribute("giftsOnPpl", $_POST['gToJoin'], $r->id);
		}
	}
	
	foreach($results as $r) {
		if (isset($_POST['cToJoin']) && isset($_POST["addC".$r->id])) {
			$Data->addAttribute("pplInCourses", $_POST['cToJoin'], $r->id);
		}
	}
	
	foreach($results as $r) {
		if (isset($_POST['sgToJoin']) && isset($_POST["addSg".$r->id])) {
			$Data->addAttribute("pplInSmallgroups", $_POST['sgToJoin'], $r->id);
		}
	}
	
	$results = $People->getPpl($search, $searchBy, $sort, $order);
	
?>
<?php require("../partials/header.php"); ?>

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
<div class = "container-full">
<?php

	$resultTbl = "<style>td.2liner {word-wrap: break-word; width:2em;}</style>";
	$resultTbl .= "<table class = 'table'>";
		$resultTbl .= "<tr>";
		
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
			$resultTbl .= "<form method = 'POST'>";
			$resultTbl .= "<td class = '2liner' style = 'text-align:center'>".$r->line_of_work;
			$resultTbl .= "<select name = 'lowToJoin'>";
			foreach ($lines_of_work as $low) {
				$resultTbl .= "<option value = '".$low->id."'>".$low->data."</option>";
			}
			$resultTbl .= "</select'>";
			$resultTbl .= "<input type = 'submit' name = 'addLow".$r->id."' value = 'Lisa Tööharu'>";
			$resultTbl .= "</td>";
			
			$resultTbl .= "<td class = '2liner' style = 'text-align:center'>".$r->gift;
			$resultTbl .= "<select name = 'gToJoin'>";
			foreach ($gifts as $g) {
				$resultTbl .= "<option value = '".$g->id."'>".$g->data."</option>";
			}
			$resultTbl .= "</select'>";
			$resultTbl .= "<input type = 'submit' name = 'addG".$r->id."' value = 'Lisa Oskus'>";
			$resultTbl .= "</td>";
			
			$resultTbl .= "<td class = '2liner' style = 'text-align:center'>".$r->course;
			$resultTbl .= "<select name = 'cToJoin'>";
			foreach ($courses as $c) {
				$resultTbl .= "<option value = '".$c->id."'>".$c->data."</option>";
			}
			$resultTbl .= "</select'>";
			$resultTbl .= "<input type = 'submit' name = 'addC".$r->id."' value = 'Lisa kursusele'>";
			$resultTbl .= "</td>";
			
			$resultTbl .= "<td class = '2liner' style = 'text-align:center'>".$r->smallgroup;
			$resultTbl .= "<select name = 'sgToJoin'>";
			foreach ($smallgroups as $sg) {
				$resultTbl .= "<option value = '".$sg->id."'>".$sg->name."</option>";
			}
			$resultTbl .= "</select'>";
			$resultTbl .= "<input type = 'submit' name = 'addSg".$r->id."' value = 'Lisa Gruppi'>";
			$resultTbl .= "</td>";
			$resultTbl .= "</form>";
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

</div>

<?php require("../partials/footer.php"); ?>