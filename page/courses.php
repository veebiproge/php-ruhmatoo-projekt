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

<br><label>Kursused</label><br>
<?php
	
	$listHtml = "<ul>";
	foreach($courses as $c) {
		if ($c->id != 0) {
			$listHtml .= "<li>".$c->data." <a class='btn btn-default btn-sm' href = 'courses.php?del=".$c->id."'>Eemalda</a></li>";
		}
	}
	$listHtml .= "</ul>";
	
	echo $listHtml;
	
?>

<br><label>Lisa uus</label><br>
<form method = "POST">
	<input type = "text" name = "course">
	<input type = "submit" value = "Salvesta">
</form>

<?php require("../partials/footer.php"); ?>