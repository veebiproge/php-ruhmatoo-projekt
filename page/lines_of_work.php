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
	
?>

<?php require("../partials/loggedInHeader.php"); ?>


<br><label>Tööharud</label><br>
<?php
	
	$listHtml = "<ul>";
	foreach($lines_of_work as $l) {
		if ($l->id != 0) {
			$listHtml .= "<li>".$l->data."</li>";
		}
	}
	$listHtml .= "</ul>";
	
	echo $listHtml;
	
?>

<br><label>Lisa uus</label><br>
<form method = "POST">
	<input type = "text" name = "line_of_work">
	<input type = "submit" value = "Salvesta">
</form>

<?php require("../partials/footer.php"); ?>