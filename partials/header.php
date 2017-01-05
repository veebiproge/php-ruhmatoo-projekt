<!DOCTYPE html>
<html>
<head>
	<title>CDB</title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="../bootstrap.css" rel="stylesheet" type="text/css">
	
	<?php require_once("../design.css");?>
	
</head>
<body>

<?php
	
	$header = "<div class = 'container-fluid'>";
	
	if (isset($_SESSION["userId"])) {
		$header .= "<nav class='navbar navbar-inverse'>";
			$header .= "<ul class='nav navbar-nav navbar-right'>";
				$header .= "<li role='presentation'><a href='profile.php?id=".$_SESSION['userId']."'>Profiil</a></li>";
				if ($_SESSION["rights"] >= 5) {
					$header .= "<li role='presentation'><a href='data1.php'>Inimesed</a></li>";
				}
				$header .= "<li role='presentation'><a href='smallgroups.php'>Kodugrupid</a></li>";
				$header .= "<li role='presentation'><a href='lines_of_work.php'>Tööharud</a></li>";
				$header .= "<li role='presentation'><a href='gifts.php'>Oskused</a></li>";
				$header .= "<li role='presentation'><a href='courses.php'>Kursused</a></li>";
				$header .= "<li role='presentation'><a href='?logout=1'>Logi välja</a></li>";
				$header .= "<li role='presentation'><a href='?logout=1'></a></li>";
			$header .= "</ul>";
		$header .= "</nav>";
	}
	
	echo $header;
	
?>