<?php
	
	require_once("../functions.php");
	
	require_once("../class/Data.class.php");
	$Data = new Data($link);
	
	if (!isset($_GET['id'])) {
		header("Location: data.php");
		exit();
	}
	
	$smallgroup = $Data->getSmallgroups($_GET['id']);
	$pplInSmallgroup = $Data->getPplInSmallgroup($_GET['id']);
	
?>

<?php require("../partials/loggedInHeader.php"); ?>

<?php
	
	$dataHtml = "<table>";
	$dataHtml .= "<tr>";
	$dataHtml .= "<td> Juht: </td>";
	$dataHtml .= "<td>".$smallgroup[0]->leader."</td>";
	$dataHtml .= "</tr>";
	$dataHtml .= "<tr>";
	$dataHtml .= "<td> Aadress: </td>";
	$dataHtml .= "<td>".$smallgroup[0]->address."</td>";
	$dataHtml .= "</tr>";
	$dataHtml .= "<tr>";
	$dataHtml .= "<td>Liikmed:";
	$dataHtml .= "<ul>";
	foreach($pplInSmallgroup as $p) {
		$dataHtml .= "<li>$p->fname $p->lname</li>";
	}
	$dataHtml .= "</ul>";
	$dataHtml .= "</tr>";
	$dataHtml .= "</table>";
	
	echo $dataHtml;
	
?>

<?php require("../partials/footer.php"); ?>