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
	
	if (isset($_POST["line_of_work"]) && !empty($_POST["line_of_work"])) {
		$Data->saveToTableOfTwo("line_of_work", $Helper->cleanInput($_POST["line_of_work"]));
	}
	
	$lines_of_work = $Data->getFromTableOfTwo("line_of_work");
	
	foreach ($lines_of_work as $l) {
		if (isset($_GET["del"]) && $_GET["del"] == $l->id) {
			$Data->removeAtt("l_o_wOnPpl", "line_of_work", $Helper->cleanInput($_GET["del"]), "line_of_work");
		}
	}
	
	$lines_of_work = $Data->getFromTableOfTwo("line_of_work");
	
?>

<?php require("../partials/header.php"); ?>

<?php
	
	$dataHtml = "";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table width = '100%'>";
				$dataHtml .= "<tr><th colspan = '2'><label>Tööharud</label></th></tr>";
				foreach($lines_of_work as $l) {
					if (is_object($l)) {
						$dataHtml .= "<tr><th>".$l->data."</th><td><a class='btn btn-default btn-sm' href = 'lines_of_work.php?del=".$l->id."'>Eemalda</a></td></tr>";
					}
				}
				$dataHtml .= "<tr><th><label>Lisa uus</label></th></tr>";
				$dataHtml .= "<form method = 'POST'>";
					$dataHtml .= "<tr><th><input type = 'text' name = 'line_of_work'></th>";
					$dataHtml .= "<td><input type = 'submit' value = 'Salvesta'></td></tr>";
				$dataHtml .= "</form>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
			
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>