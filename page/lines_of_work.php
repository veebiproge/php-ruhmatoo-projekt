<?php
	
	require_once("../functions.php");
	
	require("../class/Data.class.php");
	$Data = new Data($link);
	
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
	
	$lines_of_work = $Data->getFromTableOfTwo("line_of_work");
	
?>

<?php require("../partials/loggedInHeader.php"); ?>

<label>Tööharud</label><br>
<?php
	
	$listHtml = "<ul>";
	foreach($lines_of_work as $l) {
		$listHtml .= "<li>".$l->data."</li>";
	}
	$listHtml .= "<ul>";
	
	echo $listHtml;
	
?>

<?php require("../partials/footer.php"); ?>