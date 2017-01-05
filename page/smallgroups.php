<?php
	
	require_once("../functions.php");
	
	require_once("../class/User.class.php");
	$User = new User($link);
	
	require_once("../class/Data.class.php");
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
	
	if (isset($_POST["smallgroupName"]) && !empty($_POST["smallgroupName"]) &&
		isset($_POST["smallgroupAddress"]) && !empty($_POST["smallgroupAddress"]) &&
		isset($_POST["smallgroupMeetingTime"]) && !empty($_POST["smallgroupMeetingTime"]) &&
		isset($_POST["smallgroupLeader"])) {
		
		$Data->saveSmallgroup($Helper->cleanInput($_POST["smallgroupName"]), $Helper->cleanInput($_POST["smallgroupAddress"]), $Helper->cleanInput($_POST["smallgroupLeader"]), $Helper->cleanInput($_POST["smallgroupMeetingTime"]));
		
	}
	
	$people = $User->getPpl("", "", "", "");
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
	
	if ($_SESSION["rights"] >= 5) {
		$dataHtml .= "<div class = 'col-sm-3 col-sm-offset-4 relative'>";
			$dataHtml .= "<div class = 'smallTbl relative'>";
				$dataHtml .= "<table width = '100%'>";
					$dataHtml .= "<form method = 'POST'>";
						
						$dataHtml .= "<tr><th colspan = '2'><label>Lisa uus</label></th></tr>";
						
						$dataHtml .= "<tr>";
							$dataHtml .= "<th>Nimi:</th>";
							$dataHtml .= "<td><input type = 'text' name = 'smallgroupName'></td>";
						$dataHtml .= "</tr>";
						
						$dataHtml .= "<tr>";
							$dataHtml .= "<th>Aadress:</th>";
							$dataHtml .= "<td><input type = 'text' name = 'smallgroupAddress'></td>";
						$dataHtml .= "</tr>";
						
						$dataHtml .= "<tr>";
							$dataHtml .= "<th>Kohtumise aeg:</th>";
							$dataHtml .= "<td><input type = 'text' name = 'smallgroupMeetingTime'></td>";
						$dataHtml .= "</tr>";
						
						$dataHtml .= "<tr>";
							$dataHtml .= "<th>Juht:</th>";
							$dataHtml .= "<td><select name = 'smallgroupLeader'>";
							foreach($people as $p) {
								$dataHtml .= "<option value=".$p->id.">".$p->fname."</option>";
							}
							$dataHtml .= "</select></td>";
						$dataHtml .= "</tr>";
						
						$dataHtml .= "<tr><th></th><td><input type = 'submit' value = 'Salvesta'></td></tr>";
					
					$dataHtml .= "</form>";
				$dataHtml .= "</table>";
			$dataHtml .= "</div>";
		$dataHtml .= "</div>";
	}
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>