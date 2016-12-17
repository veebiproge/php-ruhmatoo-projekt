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

<br><label>Oskused</label><br>
<?php
	
	$listHtml = "<ul>";
	foreach($gifts as $g) {
		if (is_object($g)) {
			$listHtml .= "<li>".$g->data." <a class='btn btn-default btn-sm' href = 'gifts.php?del=".$g->id."'>Eemalda</a></li>";
		}
	}
	$listHtml .= "</ul>";
	
	echo $listHtml;
	
?>

<br><label>Lisa uus</label><br>
<form method = "POST">
	<input type = "text" name = "gift">
	<input type = "submit" value = "Salvesta">
</form>

<?php require("../partials/footer.php"); ?>