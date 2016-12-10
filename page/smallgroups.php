<?php
	
	require_once("../functions.php");
	
	if (!isset($_SESSION["userId"])){
		
		//Redirect to login page
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