<?php
	
	require("../functions.php");
	
	require("../class/People.class.php");
	$People = new People($link);
	
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
	
	if (isset($_GET["search"])) {
		$search = $Helper->cleanInput($_GET["search"]);
	} else {
		$search = "";
	}
	
	if(isset($_GET["searchBy"])) {
		$searchBy = $Helper->cleanInput($_GET["searchBy"]);
	} else {
		$searchBy = "id";
	}
	
	if (isset($_GET["sort"]) && isset($_GET["order"])) {
		$sort = $Helper->cleanInput($_GET["sort"]);
		$order = $Helper->cleanInput($_GET["order"]);
	} else {
		$sort = "id";
		$order = "ASC";
	}
	
	$results = $People->getPpl($search, $searchBy, $sort, $order);
	
?>
<?php require("../partials/header.php"); ?>

<nav class="navbar navbar-default">
	<ul class="nav navbar-nav navbar-right">
		<li role="presentation"><a href="signup.php">Lisa kodugrupp</a></li>
		<li role="presentation"><a href="#tere">Lisa kursus</a></li>
		<li role="presentation"><a href="#">Lisa tööharu</a></li>
		<li role="presentation"><a href="?logout=1">Logi välja</a></li>
	</ul>
</nav>

<form>
	Otsing:	
	<input type = "text" name = "search">
	<select name = "searchBy">
		<option value = "firstname"> Eesnimi </option>
		<option value = "lastname"> Perenimi </option>
		<option value = "email"> Email </option>
		<option value = "date_of_birth"> Sünnikuupäev </option>
		<option value = "saved"> Päästetud </option>
		<option value = "baptised"> Ristitud </option>
	</select>
	<input type = "submit" value = "Otsi"><br><br>
</form>

<?php

	$resultTbl = "<table class = 'table'>";
		$resultTbl .= "<tr border='2'>";
		
			$resultToTbl = $People->sortResults("firstname", "Eesnimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("lastname", "Perenimi", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("email", "Email", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("date_of_birth", "Sünnikuupäev", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("saved", "Päästetud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
			
			$resultToTbl = $People->sortResults("baptised", "Ristitud", $search, $searchBy);
			$resultTbl .= $resultToTbl;
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