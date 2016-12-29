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
	
	if (isset($_POST["course"]) && !empty($_POST["course"])) {
		
		$Data->saveToTableOfTwo("courses", $Helper->cleanInput($_POST["course"]));
		
	}
	
	$courses = $Data->getFromTableOfTwo("courses");
	
	foreach ($courses as $c) {
		
		if (isset($_GET["del"]) && $_GET["del"] == $c->id) {
			
			$Data->removeAtt("pplInCourses", "course", $Helper->cleanInput($_GET["del"]), "courses");
			
		}
		
	}
	
	$courses = $Data->getFromTableOfTwo("courses");
	
?>

<?php require("../partials/header.php"); ?>

<?php
	
	$dataHtml = "";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
		$dataHtml .= "<div class = 'smallTbl'>";
			$dataHtml .= "<table width = '100%'>";
				
				$dataHtml .= "<tr><th colspan = '2'><label>Kursused</label></th></tr>";
				
				foreach($courses as $c) {
					if (is_object($c)) {
						$dataHtml .= "<tr>";
							$dataHtml .= "<th>".$c->data."</th>";
							if ($_SESSION["rights"] >= 5) {
								$dataHtml .= "<td><a class='btn btn-default btn-sm' href = 'courses.php?del=".$c->id."'>Eemalda</a></td>";
							}
						$dataHtml .= "</tr>";
					}
				}
				
				if ($_SESSION["rights"] >= 5) {
					$dataHtml .= "<tr><th colspan = '2'><label>Lisa uus</label></th></tr>";
					
					$dataHtml .= "<form method = 'POST'>";
						$dataHtml .= "<tr>";
							$dataHtml .= "<th><input type = 'text' name = 'course'></th>";
							$dataHtml .= "<td><input type = 'submit' value = 'Salvesta'></td>";
						$dataHtml .= "</tr>";
					$dataHtml .= "</form>";
				}
				
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>