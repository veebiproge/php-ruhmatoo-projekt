<?php
	
	require_once("../functions.php");
	
	require_once("../class/People.class.php");
	$People = new People($link);
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
	require_once("../class/Helper.class.php");
	$Helper = new Helper();
	
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
	
	if (isset($_POST["smallgroupName"]) && !empty($_POST["smallgroupName"]) &&
		isset($_POST["smallgroupAddress"]) && !empty($_POST["smallgroupAddress"]) &&
		isset($_POST["smallgroupLeader"])) {
		
		$Data->saveSmallgroup($Helper->cleanInput($_POST["smallgroupName"]), $Helper->cleanInput($_POST["smallgroupAddress"]), $Helper->cleanInput($_POST["smallgroupLeader"]));
		
	}
	
	$people = $People->getPpl("", "", "", "");
	$smallgroups = $Data->getSmallgroups("");
	
?>

<?php require("../partials/header.php"); ?>

<?php
	
	$dataHtml = "";
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
		$dataHtml .= "<div class = 'smallTbl relative'>";
			$dataHtml .= "<table width = '100%'>";
				$dataHtml .= "<tr><th><label>Kodugrupid</label></th></tr>";
				foreach($smallgroups as $sg) {
					if (is_object($sg)) {
						$dataHtml .= "<tr><th>".$sg->name."</th><td><a class='btn btn-default btn-sm' href = 'smallgroup.php?id=".$sg->id."'>Vaata lähemalt</a></td></tr>";
					}
				}
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
		$dataHtml .= "<div class = 'smallTbl relative'>";
			$dataHtml .= "<table width = '100%'>";
				$dataHtml .= "<form method = 'POST'>";
				$dataHtml .= "<tr><th colspan = '2'><label>Lisa uus</label></th></tr>";
				$dataHtml .= "<tr><th>Nimi:</th>";
				$dataHtml .= "<td><input type = 'text' name = 'smallgroupName'></td></tr>";
				$dataHtml .= "<tr><th>Aadress:</th>";
				$dataHtml .= "<td><input type = 'text' name = 'smallgroupAddress'></td></tr>";
				$dataHtml .= "<tr><th>Juht:</th>";
				$dataHtml .= "<td><select name = 'smallgroupLeader'>";
				foreach($people as $p) {
					$dataHtml .= "<option value=".$p->id.">".$p->fname."</option>";
				}
				$dataHtml .= "</select></td></tr>";
				$dataHtml .= "<tr><th></th><td><input type = 'submit' value = 'Salvesta'></td></tr>";
				$dataHtml .= "</form>";
			$dataHtml .= "</table>";
		$dataHtml .= "</div>";
	$dataHtml .= "</div>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>