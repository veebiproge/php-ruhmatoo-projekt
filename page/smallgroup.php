<?php
	
	require_once("../functions.php");
	
	require_once("../class/People.class.php");
	$People = new People($link);
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
	require_once("../class/Helper.class.php");
	$Helper = new Helper();
	
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
	
	foreach ($pplInSmallgroup as $m) {
		if (isset($_POST["del".$m->person])) {
			$Data->removeAttribute("pplInSmallgroups", "smallgroup", ($m->person), ($Helper->cleanInput($_GET["id"])));
		}
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
				$dataHtml .= "<tr><th colspan = '2'><center>".$smallgroup[0]->name."</center></th></tr>";
				$dataHtml .= "<tr><th> Juht: </th>";
				$dataHtml .= "<td colspan = '2'><select name = 'leader'>";
				foreach($ppl as $p) {
					$dataHtml .= "<option value ='".$p->id."' ";
					if ($p->id == $smallgroup[0]->leaderId) {
						$dataHtml .= " selected ";
					}
					$dataHtml .= ">".$p->fname." ".$p->lname."</option>";
				}
				$dataHtml .= "</select></td>";
				$dataHtml .= "</tr>";
				$dataHtml .= "<tr>";
				$dataHtml .= "<th> Aadress: </th>";
				$dataHtml .= "<td colspan = '2'><input type = 'text' name = 'address' value = '".$smallgroup[0]->address."'></td>";
				$dataHtml .= "</tr>";
				$dataHtml .= "<tr>";
				$dataHtml .= "<tr><th rowspan = ".$numberOfMembers.">Liikmed:</th>";
				foreach($pplInSmallgroup as $m) {
					if ($m != $pplInSmallgroup[0]) {$dataHtml .= "<tr>";}
					$dataHtml .= "<td>".$m->fname." ".$m->lname."</td>";
					$dataHtml .= "<td><input type = 'submit' name = 'del".$m->person."' value = 'Eemalda'></td></tr>";
				}
				if ($numberOfMembers == 0) {
					$dataHtml .= "<td></td></tr>";
				}
				$dataHtml .= "<tr><th></th><td colspan = '2'><input type = 'submit' name = 'save' value = 'Salvesta'><input type = 'submit' name = 'del' value = 'Kustuta'></td></tr>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	$dataHtml .= "</form>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>