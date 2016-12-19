<?php
	
	require_once("../functions.php"); 
	
	require("../class/Data.class.php");
	$Data = new Data($link);
	
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
	
	if (!isset($_GET["id"])) {
		header("Location: data.php");
		exit();
		
	} elseif ($_SESSION["rights"] < 5 && $_GET["id"] != $_SESSION["userId"]) {
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	if (isset($_POST["baptised_y"]) && isset($_POST["baptised_m"]) && isset($_POST["baptised_d"])) {
		$baptised = $Helper->cleanInput($_POST["baptised_y"])."-".$Helper->cleanInput($_POST["baptised_m"])."-".$Helper->cleanInput($_POST["baptised_d"]);
	}
	
	if (isset($_POST["saved_y"]) && isset($_POST["saved_m"]) && isset($_POST["saved_d"])) {
		$saved = $Helper->cleanInput($_POST["saved_y"])."-".$Helper->cleanInput($_POST["saved_m"])."-".$Helper->cleanInput($_POST["saved_d"]);
	}
	
	if (isset($_POST["email"]) && isset($_POST["phone"]) && isset($saved) && !empty($saved) && isset($baptised) && !empty($baptised)) {
		
		$index = $Helper->cleanInput($_GET["id"]);
		$email = $Helper->cleanInput($_POST["email"]);
		
		if (empty($_POST["phone"])) {
			$phone = "";
		} else {
			$phone = $Helper->cleanInput($_POST["phone"]);
		}
		
		$People->updatePerson($index, "email", $email);
		$People->updatePerson($index, "phonenumber", $phone);
		$People->updatePerson($index, "saved", $saved);
		$People->updatePerson($index, "baptised", $baptised);
		
		header("Location: profile.php?id=".$index);
	}
	
	$person = $People->getPerson($Helper->cleanInput($_GET["id"]));
	
	foreach ($person[0]->line_of_work as $l) {
		if (isset($_POST["del".$l->id])) {
			$Data->removeAttribute("l_o_wOnPpl", "line_of_work", ($person[0]->id), ($l->id));
		}
	}
	
	foreach ($person[0]->gift as $g) {
		if (isset($_POST["del".$g->id])) {
			$Data->removeAttribute("giftsOnPpl", "gift", ($person[0]->id), ($g->id));
		}
	}
	
	foreach ($person[0]->course as $c) {
		if (isset($_POST["del".$c->id])) {
			$Data->removeAttribute("pplInCourses", "course", ($person[0]->id), ($c->id));
		}
	}
	
	foreach ($person[0]->smallgroup as $sg) {
		if (isset($_POST["del".$sg->id])) {
			$Data->removeAttribute("pplInSmallgroups", "smallgroup", ($person[0]->id), ($sg->id));
		}
	}

	
	$person = $People->getPerson($Helper->cleanInput($_GET["id"]));
	
?>

<?php require("../partials/header.php"); ?>

<?php

	if (count($person[0]->line_of_work) < 1) {
		$person[0]->line_of_work[0] = "";
	}
	
	if (count($person[0]->gift) < 1) {
		$person[0]->gift[0] = "";
	}
	
	if (count($person[0]->course) < 1) {
		$person[0]->course[0] = "";
	}
	
	if (count($person[0]->smallgroup) < 1) {
		$person[0]->smallgroup[0] = "";
	}
	
	$numberOfLOW = count($person[0]->line_of_work);
	$numberOfGifts = count($person[0]->gift);
	$numberOfCourses = count($person[0]->course);
	$numberOfSmallgroups = count($person[0]->smallgroup);
	$numberOfSmallgroupsToLead = count($person[0]->smallgroupToLead);
	
	$dataHtml = "";
	$dataHtml .= "<div class = 'row2'>";
	$dataHtml .= "<form method = 'POST'>";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-1 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table><tr><th>Eesnimi: </th>";
			$dataHtml .= "<td>".$person[0]->fname."</td></tr>";
			$dataHtml .= "<tr><th>Perekonnanimi: </th>";
			$dataHtml .= "<td>".$person[0]->lname."</td></tr>";
			$dataHtml .= "<tr><th>Email: </th>";
			$dataHtml .= "<div class='input-group'>";
			$dataHtml .= "<td><input type = 'text' name = 'email' class = 'form-control' value = '".$person[0]->email."'></td></tr>";
			$dataHtml .= "<tr><th>Telefon:</th>";
			$dataHtml .= "<td><input type = 'text' name = 'phone' class = 'form-control' value = '".$person[0]->phonenumber."'></td></tr>";
			$dataHtml .= "</div>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-3 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table>";
			$dataHtml .= "<tr><th rowspan = ".$numberOfLOW.">Tööharud:</th>";
			foreach($person[0]->line_of_work as $l) {
				if ($l != $person[0]->line_of_work[0]) {$dataHtml .= "<tr>";}
				if (is_object($l)) {
					$dataHtml .= "<td>".$l->name."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$l->id."' value = 'Eemalda'></td></tr>";
				} else {
					$dataHtml .= "<td colspan = '2'>".$l."</td></tr>";
				}
			}
			$dataHtml .= "<tr><th rowspan = ".$numberOfGifts.">Oskused:</th>";
			foreach($person[0]->gift as $g) {
				if ($g != $person[0]->gift[0]) {$dataHtml .= "<tr>";}
				if (is_object($g)) {
					$dataHtml .= "<td>".$g->name."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$g->id."' value = 'Eemalda'></td></tr>";
				} else {
					$dataHtml .= "<td colspan = '2'>".$g."</td></tr>";
				}
			}
			$dataHtml .= "<tr><th rowspan = ".$numberOfCourses.">Kursused:</th>";
			foreach($person[0]->course as $c) {
				if ($c != $person[0]->course[0]) {$dataHtml .= "<tr>";}
				if (is_object($c)) {
					$dataHtml .= "<td>".$c->name."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$c->id."' value = 'Eemalda'></td></tr>";
				} else {
					$dataHtml .= "<td colspan = '2'>".$c."</td></tr>";
				}
			}
			$dataHtml .= "<tr><th rowspan = ".$numberOfSmallgroups.">Väikegruppid(osaleja):</th>";
			foreach($person[0]->smallgroup as $s) {
				if ($s != $person[0]->smallgroup[0]) {$dataHtml .= "<tr>";}
				if (is_object($s)) {
					$dataHtml .= "<td>".$s->name."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$s->id."' value = 'Eemalda'></td></tr>";
				} else {
					$dataHtml .= "<td colspan = '2'>".$s."</td></tr>";
				}
			}
			if ($numberOfSmallgroupsToLead > 0) {
				$dataHtml .= "<tr><th rowspan = ".$numberOfSmallgroupsToLead.">Väikegruppid(juht):</th>";
				foreach($person[0]->smallgroupToLead as $sl) {
					if ($sl != $person[0]->smallgroupToLead[0]) {$dataHtml .= "<tr>";}
					if (is_object($sl)) {
					$dataHtml .= "<td>".$sl->name."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$sl->id."' value = 'Eemalda'></td></tr>";
				} else {
					$dataHtml .= "<td colspan = '2'>".$sl."</td></tr>";
				}
				}
			}
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	$dataHtml .= "<div class = 'row1'>";
	
	
	$dataHtml .= "<div class = 'col-sm-6 col-sm-offset-1 relative'>";
		$dataHtml .= "<div class = 'wideTbl relative'>";
			$dataHtml .= "<table>";
				$dataHtml .= "<tr><th>Sünnikuupäev:</th>";
				$dataHtml .= "<td>".$person[0]->dob."</td></tr>";
				$dataHtml .= "<tr><th>Päästetud:</th>";
				$dataHtml .= "<td colspan = '2'><select name = 'saved_y'>";
				$dataHtml .= "<option value = '0'>0</option>";
				for ($i=1900; $i<=2016; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->saved),0,4)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>-";
				$dataHtml .= "<select name = 'saved_m'>";
				for ($i=0; $i<=12; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->saved),5,2)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>-";
				$dataHtml .= "<select name = 'saved_d'>";
				for ($i=0; $i<=31; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->saved),8,2)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>";
				$dataHtml .= "<tr><th>Ristitud:</th>";
				$dataHtml .= "<td><select name = 'baptised_y'>";
				$dataHtml .= "<option value = '0'>0</option>";
				for ($i=1900; $i<=2016; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->baptised),0,4)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>-";
				$dataHtml .= "<select name = 'baptised_m'>";
				for ($i=0; $i<=12; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->baptised),5,2)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>-";
				$dataHtml .= "<select name = 'baptised_d'>";
				for ($i=0; $i<=31; $i+=1) {
					$dataHtml .= "<option value = '".$i."' ";
					if ($i==substr(($person[0]->baptised),8,2)) {
						$dataHtml .= "selected";
					}
					$dataHtml .= ">".$i."</option>";
				}
				$dataHtml .= "</select>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	$dataHtml .= "<div class = 'col-sm-3 relative'>";
		$dataHtml .= "<div class = 'wideTbl relative'>";
			$dataHtml .= "<table>";
			$dataHtml .= "<tr><th width = 250px height = 150px><center><input type = 'submit' value = 'Salvesta'></center></th></tr>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	
	$dataHtml .= "</form>";
	
	echo $dataHtml
	
?>

<?php require("../partials/footer.php"); ?>