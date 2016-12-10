<?php

	require("/home/nikopeos/config.php");
	
	$database = "if16_case112";
	$link = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	session_start();

?>