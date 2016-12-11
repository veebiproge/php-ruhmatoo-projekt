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

	
?>

<?php require("../partials/loggedInHeader.php"); ?>

<?php require("../partials/footer.php"); ?>