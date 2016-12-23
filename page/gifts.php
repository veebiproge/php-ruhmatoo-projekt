<?php
	
	require_once("../functions.php");
	
	require("../class/Data.class.php");
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
	
	if (isset($_POST["gift"]) && !empty($_POST["gift"])) {
		$Data->saveToTableOfTwo("gifts", $Helper->cleanInput($_POST["gift"]));
	}
	
	$gifts = $Data->getFromTableOfTwo("gifts");
	
	foreach ($gifts as $g) {
		if (isset($_GET["del"]) && $_GET["del"] == $g->id) {
			$Data->removeAtt("giftsOnPpl", "gift", $Helper->cleanInput($_GET["del"]), "gifts");
		}
	}
	
	$gifts = $Data->getFromTableOfTwo("gifts");
	
?>

<?php require("../partials/header.php"); ?>

<?php

	$dataHtml = "";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table width = '100%'>";
				$dataHtml .= "<tr><th colspan = '2'><label>Oskused</label></th></tr>";
				foreach($gifts as $g) {
					if (is_object($g)) {
						$dataHtml .= "<tr><th>".$g->data."</th><td><a class='btn btn-default btn-sm' href = 'gifts.php?del=".$g->id."'>Eemalda</a></td></tr>";
					}
				}
				$dataHtml .= "<tr><th><label>Lisa uus</label></th></tr>";
				$dataHtml .= "<form method = 'POST'>";
					$dataHtml .= "<tr><th><input type = 'text' name = 'gift'></th>";
					$dataHtml .= "<td><input type = 'submit' value = 'Salvesta'></td></tr>";
				$dataHtml .= "</form>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>