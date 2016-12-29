<?php
	
	require_once("../functions.php");
	
	require_once("../class/People.class.php");
	$People = new People($link);
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
	require_once("../class/Helper.class.php");
	$Helper = new Helper();
	
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
		
	}
	
	if (!isset($_GET["id"])) {
		
		header("Location: data.php");
		exit();
		
	}
	
	if (isset($_POST["save"])) {
		
		$leader = $Helper->cleanInput($_POST["leader"]);
		$address = $Helper->cleanInput($_POST["address"]);
		$index = $Helper->cleanInput($_GET["id"]);
		$Data->updateSmallgroup($index, $leader, $address);
		header("Location: smallgroup.php?id=".$_GET["id"]."&save=success");
		
	}
	
	if (isset($_POST["del"])) {
		
		$index = $Helper->cleanInput($_GET["id"]);
		$Data->delSmallgroup($index);
		header("Location: smallgroups.php");
		
	}
	
	$ppl = $People->getPpl("", "", "", "");
	$pplInSmallgroup = $Data->getPplInSmallgroup($Helper->cleanInput($_GET["id"]));
	$smallgroup = $Data->getSmallgroups($Helper->cleanInput($_GET["id"]));
	$idsInGroup = array();
	
	foreach ($pplInSmallgroup as $m) {
		
		if (isset($_POST["del".$m->person])) {
			
			$Data->removeAttribute("pplInSmallgroups", "smallgroup", ($m->person), ($Helper->cleanInput($_GET["id"])));
			
		} else {
			
			array_push($idsInGroup, $m->person);
			
		}
		
	}
	
	if (!in_array($_SESSION["userId"], $idsInGroup)) {
		
		header("Location: profile.php?id=".$_SESSION["userId"]);
		exit();
		
	}
	
	$pplInSmallgroup = $Data->getPplInSmallgroup($Helper->cleanInput($_GET["id"]));
	
	
?>

<?php require("../partials/header.php"); ?>

<?php
	
	$numberOfMembers = count($pplInSmallgroup);
	
	$dataHtml = "<form method = 'POST'>";
		$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
			$dataHtml .= "<div class = 'smallTbl'>";
				$dataHtml .= "<table width = '100%'>";
					
					$dataHtml .= "<tr><th colspan = '3'><center>".$smallgroup[0]->name."</center></th></tr>";
					
					$dataHtml .= "<tr>";
						$dataHtml .= "<th> Juht: </th>";
						if ($_SESSION["rights"] >= 5) {
							$dataHtml .= "<td colspan = '2'><select name = 'leader'>";
								foreach($ppl as $p) {
									$dataHtml .= "<option value ='".$p->id."' ";
									if ($p->id == $smallgroup[0]->leaderId) {
										$dataHtml .= " selected ";
									}
									$dataHtml .= ">".$p->fname." ".$p->lname."</option>";
								}
							$dataHtml .= "</select></td>";
						} else {
							$dataHtml .= "<td colspan = '2'>".$smallgroup[0]->leaderFirstname." ".$smallgroup[0]->leaderLastname."</td>";
						}
					$dataHtml .= "</tr>";
					
					$dataHtml .= "<tr>";
						$dataHtml .= "<th> Aadress: </th>";
						if ($_SESSION["rights"] >= 5 OR $smallgroup[0]->leaderId == $_SESSION["userId"]) {
							$dataHtml .= "<td colspan = '2'><input type = 'text' name = 'address' value = '".$smallgroup[0]->address."'></td>";
						} else {
							$dataHtml .= "<td colspan = '2'>".$smallgroup[0]->address."</td>";
						}
					$dataHtml .= "</tr>";
					
					$dataHtml .= "<tr><th rowspan = ".$numberOfMembers.">Liikmed:</th>";
					foreach($pplInSmallgroup as $m) {
						if ($m != $pplInSmallgroup[0]) {$dataHtml .= "<tr>";}
						$dataHtml .= "<td>".$m->fname." ".$m->lname."</td>";
						if ($m->person == $_SESSION["userId"]) {
							$dataHtml .= "<td><center><input type = 'submit' name = 'del".$m->person."' value = 'Eemalda'></center></td></tr>";
						} else {
							$dataHtml .= "<td></td></tr>";
						}
					}
					if ($numberOfMembers == 0) {
						$dataHtml .= "<td></td></tr>";
					}
					
					if ($_SESSION["rights"] >= 5 OR $smallgroup[0]->leaderId == $_SESSION["userId"]) {
						$dataHtml .= "<tr>";
							$dataHtml .= "<th></th>";
							$dataHtml .= "<td><center><input type = 'submit' name = 'save' value = 'Salvesta'></center></td>";
							$dataHtml .= "<td><center><input type = 'submit' name = 'del' value = 'Kustuta'></center></td>";
						$dataHtml .= "</tr>";
					}
				
				$dataHtml .= "</table>";
			$dataHtml .= "</div>";
		$dataHtml .= "</div>";
	$dataHtml .= "</form>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>