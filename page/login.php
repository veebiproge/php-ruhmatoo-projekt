
<?php 
	
	require("../functions.php");
	
	require("../class/User.class.php");
	$User = new User($link);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	//muutujad
	$error ="";
	
	// kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
		header("Location: profile.php?id=".$_SESSION["userId"]);
		exit();
		
	}
	
	if ( isset($_POST["loginUsername"]) && 
		isset($_POST["loginPassword"]) && 
		!empty($_POST["loginUsername"]) && 
		!empty($_POST["loginPassword"])
	  ) {
		  
		$error = $User->login($Helper->cleanInput($_POST["loginUsername"]), $Helper->cleanInput($_POST["loginPassword"]));
		
	}

?>

<?php require("../partials/header.php"); ?>

	<div class="container">
	
		<div class="row1">	
		
			<div class="col-sm-4 col-sm-offset-4">
			
			<h2>Logi sisse</h2>
				<form method="POST">
					<p style="color:red;"><?=$error;?></p>
					<br>
						<div class="form-group">
							<input class="form-control" name="loginUsername" placeholder="E-mail / Kasutajanimi" type="text">
						</div>
					<br>
					<input class="form-control" type="password" name="loginPassword" placeholder="Parool">
					<br><br>
					<input class="btn btn-success btn-sm btn-block btn-block hidden-xs" type="submit" value="Logi sisse">
					<input class="btn btn-success btn-sm btn-block btn-block visible-xs-block" type="submit" value="Logi sisse">
						
				</form>
				<br>
				
				<form action="signup.php">
					<input type="submit" class="btn btn-primary btn-sm btn-block btn-block hidden-xs" value="Loo kasutaja">
					<input type="submit" class="btn btn-primary btn-sm btn-block btn-block visible-xs-block" value="Loo kasutaja">
				</form>
			
			</div>
			
		</div>
		
	</div>
	
<?php require("../partials/footer.php"); ?>

