<?php
	
	require_once("../functions.php"); 
	
	require_once("../class/User.class.php");
	$User = new User($link);
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
	require_once("../class/Helper.class.php");
	$Helper = new Helper();
	
	if (!isset($_SESSION["userId"])){
		
		header("Location: login.php");
		exit();
		
	} elseif ($_SESSION["rights"] < 5) {
		
		header("Location: profile.php?id=".$_SESSION["userId"]);
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
	$results = $User->getPpl($search, $searchBy, $sort, $order);
	
	foreach($results as $r) {
		
		if (isset($_POST['lowToJoin']) && isset($_POST["addLow".$r->id])) {
			
			$Data->addAttribute("l_o_wOnPpl", $Helper->cleanInput($_POST['lowToJoin']), $r->id);
			
		} elseif (isset($_POST['gToJoin']) && isset($_POST["addG".$r->id])) {
			
			$Data->addAttribute("giftsOnPpl", $Helper->cleanInput($_POST['gToJoin']), $r->id);
			
		} elseif (isset($_POST['cToJoin']) && isset($_POST["addC".$r->id])) {
			
			$Data->addAttribute("pplInCourses", $Helper->cleanInput($_POST['cToJoin']), $r->id);
			
		} elseif (isset($_POST['sgToJoin']) && isset($_POST["addSg".$r->id])) {
			
			$Data->addAttribute("pplInSmallgroups", $Helper->cleanInput($_POST['sgToJoin']), $r->id);
			
		} elseif (isset($_POST["approve".$r->id])) {
			
			$User->approve($r->id);
			
		} elseif (isset($_POST["archive".$r->id])) {
			
			$User->archive($r->id);
			
		}
		
	}
	
	$results = $User->getPpl($search, $searchBy, $sort, $order);
	
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
	$resultTbl .= "<ul class='nav nav-tabs nav-justified'>";
		$resultTbl .= "<li role='presentation'><a href='data1.php'>Isikuandmed</a></li>";
		$resultTbl .= "<li role='presentation'><a href='data2.php'>Teenimisega seonduv</a></li>";
		$resultTbl .= "<li role='presentation'><a href='signup.php'>Lisa uus inimene</a></li>";
	$resultTbl .= "</ul>";
	$resultTbl .= "<table class = 'table' width = '100%'>";
		$resultTbl .= "<tr>";
		
			$resultToTbl = $User->sortResults("firstname", "Eesnimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $User->sortResults("lastname", "Perenimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $User->sortResults("email", "Email", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $User->sortResults("phonenumber", "Telefoninumber", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			
			$resultToTbl = $User->sortResults("date_of_birth", "Sünnikuupäev", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $User->sortResults("saved", "Päästetud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $User->sortResults("baptised", "Ristitud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultTbl .= "<th><center>Staatus</center></th>";
			
			if ($_SESSION["rights"] >= 5) {
				$resultTbl .= "<th></th>";
			}
			
		$resultTbl .= "</tr>";
		
			foreach($results as $r) {
				$resultTbl .= "<tr>";
					$resultTbl .= "<form method = 'POST'>";
					$resultTbl .= "<td style = 'text-align:center'>".$r->fname."</td>";
					$resultTbl .= "<td style = 'text-align:center'>".$r->lname."</td>";
					$resultTbl .= "<td style = 'text-align:center'>".$r->email."</td>";
					$resultTbl .= "<td style = 'text-align:center'>".$r->phonenumber."</td>";
					$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->dob."</td>";
					$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->saved."</td>";
					$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->baptised."</td>";
					if ($r->app == 1) {
						$resultTbl .= "<td><center><input type = 'submit' name = 'archive".$r->id."' value = 'Arhiveeri'></center></td>";
					} else {
						$resultTbl .= "<td><center><input type = 'submit' name = 'approve".$r->id."' value = 'Aktiveeri'></center></td>";
					}
					if ($_SESSION["rights"] >= 5) {
						$resultTbl .= "<td style = 'text-align:center' width = '100'> <a class='btn btn-default btn-sm' href = 'profile.php?id=".$r->id."'>Vaata</a> </td>";
				}
			$resultTbl .= "</tr>";
			}
		
	echo $resultTbl
?>

</div>

<?php require("../partials/footer.php"); ?>