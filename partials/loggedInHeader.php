<!DOCTYPE html>
<?php
	
?>
<html>
<head>
	<title>CDB</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	
</head>
<body>
<div class = "container-fluid">
<nav class="navbar navbar-default">
	<ul class="nav navbar-nav navbar-right">
		<li role="presentation"><a href="profile.php?id=<?=$_SESSION["userId"]?>">Profiil</a></li>
		<li role="presentation"><a href="data.php">Inimesed</a></li>
		<li role="presentation"><a href="smallgroups.php">Kodugrupid</a></li>
		<li role="presentation"><a href="courses.php">Kursused</a></li>
		<li role="presentation"><a href="gifts.php">Oskused</a></li>
		<li role="presentation"><a href="lines_of_work.php">Tööharud</a></li>
		<li role="presentation"><a href="?logout=1">Logi välja</a></li>
		<li role="presentation"><a href="?logout=1"></a></li>
	</ul>
</nav>

