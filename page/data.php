<?php
	
	require("../functions.php");
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	//If no user ID
	if (!isset($_SESSION["userId"])){
		
		//Redirect to login page
		header("Location: login.php");
		exit();
	}
	
	
	//If logout is in the address bar, then log out
	if (isset($_GET["logout"])) {
		
		session_destroy();
		header("Location: login.php");
		exit();
	}
	
	
	
?>
<?php require("../partials/header.php"); ?>


<a href="?logout=1">Logi välja</a><br><br>




Otsing: <input type = "text" name = "search"> <input type = "submit" value = "Otsi"><br><br>

<?php
	$resultTbl = '<table>';
		$resultTbl .= '<tr>';
			$resultTbl .= '<td style = "text-align:center"> Nimi </td>';
			$resultTbl .= '<td style = "text-align:center"> Perenimi </td>';
		$resultTbl .= '</tr>';
		
	echo $resultTbl
?>

<?php require("../partials/footer.php"); ?>