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

<?php require("../partials/loggedInHeader.php"); ?>

<br><label>Kodugrupid</label><br>
<?php
	
	$listHtml = "<ul>";
	foreach($smallgroups as $sg) {
		if ($sg->id != 0) {
			$listHtml .= "<li>".$sg->name." <a class='btn btn-default btn-sm' href = 'smallgroup.php?id=".$sg->id."'>Vaata lähemalt</a></li>";
		}
	}
	$listHtml .= "</ul>";

	echo $listHtml;
	
?>

<br><label>Lisa uus</label><br>
<form method = "POST">
	<table class = "table" >
		<div class = "row">
			<div class = "col-md-1">Nimi:</div>
			<div class = "col-md-1"><input type = "text" name = "smallgroupName"></div>
		</div>
		<div class = "row">
			<div class = "col-md-1">Aadress:</div>
			<div class = "col-md-1"><input type = "text" name = "smallgroupAddress"></div>
		</div>
		<div class = "row">
			<div class = "col-md-1">Juht:</div>
			<div class = "col-md-1">
			<select name = "smallgroupLeader">
				<?php foreach($people as $p) {
					echo "<option value=".$p->id.">".$p->fname."</option>";
				}
				?>
			</select>
			</div>
		</div>
		<div class = "row">
		<div class = "col-md-1"></div>
		<div class = "col-md-1"><input type = "submit" value = "Salvesta"></div>
		</div>
	</table>
</form>

<?php require("../partials/footer.php"); ?>