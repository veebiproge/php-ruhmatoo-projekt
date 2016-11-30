<?php
	
	require("../functions.php");
	
	require("../class/Data.class.php");
	$Data = new Data($link);
	
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
	
	$results = $Data->getAllPpl();
	
?>
<?php require("../partials/header.php"); ?>


<a href="?logout=1">Logi välja</a><br><br>




Otsing: <input type = "text" name = "search"> 
	<select name = "searchby">
		<option value = "firstname"> Eesnimi </option>
		<option value = "lastname"> Perenimi </option>
		<option value = "email"> Email </option>
		<option value = "date_of_birth"> Sünnikuupäev </option>
		<option value = "saved"> Päästetud </option>
		<option value = "baptised"> Ristitud </option>
	</select>
	<input type = "submit" value = "Otsi"><br><br>

<?php
	$resultTbl = "<table>";
		$resultTbl .= "<tr border='2'>";
			$resultTbl .= "<th style = 'text-align:center'> Eesnimi </th>";
			$resultTbl .= "<th style = 'text-align:center'> Perenimi </th>";
			$resultTbl .= "<th style = 'text-align:center'> Email </th>";
			$resultTbl .= "<th style = 'text-align:center'> Sünnikuupäev </th>";
			$resultTbl .= "<th style = 'text-align:center'> Päästetud </th>";
			$resultTbl .= "<th style = 'text-align:center'> Ristitud </th>";
		$resultTbl .= "</tr>";
		
		foreach($results as $r) {
			$resultTbl .= "<tr>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->fname."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->lname."</td>";
			$resultTbl .= "<td style = 'text-align:center'>".$r->email."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->dob."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->saved."</td>";
			$resultTbl .= "<td style = 'text-align:center' width = '100'>".$r->baptised."</td>";
		$resultTbl .= "</tr>";
		}
		
	echo $resultTbl
?>

<?php require("../partials/footer.php"); ?>