<?php
	
	require_once("../functions.php"); 
	
	require("../class/Data.class.php");
	$Data = new Data($link);
	
	require_once("../class/User.class.php");
	$User = new User($link);
	
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
	
	if (!isset($_GET["id"])) {
		
		header("Location: profile.php?id=".$_SESSION["userId"]);
		exit();
		
	} elseif ($_SESSION["rights"] < 5 && $_GET["id"] != $_SESSION["userId"]) {
		
		header("Location: profile.php?id=".$_SESSION["userId"]);
		exit();
		
	} elseif (isset($_POST["change"])) {
		
		header("Location: editprofile.php?id=".$Helper->cleanInput($_GET['id']));
		
	}
	
	$person = $User->getPerson($Helper->cleanInput($_GET["id"]));
	
?>

<?php require("../partials/header.php"); ?>

<?php

	if (count($person[0]->line_of_work) < 1) {$person[0]->line_of_work[0] = "";}
	if (count($person[0]->gift) < 1) {$person[0]->gift[0] = "";}
	if (count($person[0]->course) < 1) {$person[0]->course[0] = "";}
	if (count($person[0]->smallgroup) < 1) {$person[0]->smallgroup[0] = "";}
	
	$numberOfLOW = count($person[0]->line_of_work);
	$numberOfGifts = count($person[0]->gift);
	$numberOfCourses = count($person[0]->course);
	$numberOfSmallgroups = count($person[0]->smallgroup);
	$numberOfSmallgroupsToLead = count($person[0]->smallgroupToLead);
	
	$dataHtml = "";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-1 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table width = '100%'>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Eesnimi: </th>";
					$dataHtml .= "<td>".$person[0]->fname."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Perekonnanimi: </th>";
					$dataHtml .= "<td>".$person[0]->lname."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Email: </th>";
					$dataHtml .= "<td>".$person[0]->email."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Telefon:</th>";
					$dataHtml .= "<td>".$person[0]->phonenumber."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Sünnikuupäev:</th>";
					$dataHtml .= "<td>".$person[0]->dob."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Päästetud:</th>";
					$dataHtml .= "<td>".$person[0]->saved."</td>";
				$dataHtml .= "</tr>";
				
				$dataHtml .= "<tr>";
					$dataHtml .= "<th>Ristitud:</th>";
					$dataHtml .= "<td>".$person[0]->baptised."</td>";
				$dataHtml .= "</tr>";
			
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	
	$dataHtml .= "<div class = 'col-sm-5 col-sm-offset-2 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table width = '100%'>";
				$dataHtml .= "<form method = 'POST'>";
					
					$dataHtml .= "<tr><th rowspan = ".$numberOfLOW.">Tööharud:</th>";
					foreach($person[0]->line_of_work as $l) {
						if ($l != $person[0]->line_of_work[0]) {$dataHtml .= "<tr>";}
						if (is_object($l)) {
							$dataHtml .= "<td>".$l->name."</td></tr>";
						} else {
							$dataHtml .= "<td>".$l."</td></tr>";
						}
					}
					
					$dataHtml .= "<tr><th rowspan = ".$numberOfGifts.">Oskused:</th>";
					foreach($person[0]->gift as $g) {
						if ($g != $person[0]->gift[0]) {$dataHtml .= "<tr>";}
						if (is_object($g)) {
							$dataHtml .= "<td>".$g->name."</td></tr>";
						} else {
							$dataHtml .= "<td>".$g."</td></tr>";
						}
					}
					
					$dataHtml .= "<tr><th rowspan = ".$numberOfCourses.">Kursused:</th>";
					foreach($person[0]->course as $c) {
						if ($c != $person[0]->course[0]) {$dataHtml .= "<tr>";}
						if (is_object($c)) {
							$dataHtml .= "<td>".$c->name."</td></tr>";
						} else {
							$dataHtml .= "<td>".$c."</td></tr>";
						}
					}
					
					
					$dataHtml .= "<tr><th rowspan = ".$numberOfSmallgroups.">Väikegruppid(osaleja):</th>";
					foreach($person[0]->smallgroup as $s) {
						if ($s != $person[0]->smallgroup[0]) {$dataHtml .= "<tr>";}
						if (is_object($s)) {
							$dataHtml .= "<td>".$s->name."</td></tr>";
						} else {
							$dataHtml .= "<td>".$s."</td></tr>";
						}
					}
					
					if ($numberOfSmallgroupsToLead > 0) {
						$dataHtml .= "<tr><th rowspan = ".$numberOfSmallgroupsToLead.">Väikegruppid(juht):</th>";
						foreach($person[0]->smallgroupToLead as $sl) {
							if ($sl != $person[0]->smallgroupToLead[0]) {$dataHtml .= "<tr>";}
							if (is_object($sl)) {
								$dataHtml .= "<td>".$sl->name."</td></tr>";
							} else {
								$dataHtml .= "<td>".$sl."</td></tr>";
						}
						}
					}
					
					$dataHtml .= "<tr><th></th><td><input type = 'submit' name = 'change' value = 'Muuda'</td></tr>";
				
				$dataHtml .= "</form>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>