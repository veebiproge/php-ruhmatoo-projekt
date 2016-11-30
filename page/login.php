<?php 
	
	require("../functions.php");
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	// kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: data.php");
		exit();
		
	}
	

	//echo hash("sha512", "b");
	
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("äö");
	
	// MUUTUJAD
	$signupUserName = "";
	$signupUserNameError = "";
	$signupPasswordError = "";
	$signupEmail = "";
	$signupEmailError = "";
	$firstname = "";
	$firstnameError = "";
	$lastname = "";
	$lastnameError = "";
	$signupGender = "";
	$dateOfBirth = "";

	// on üldse olemas selline muutja
	if( isset( $_POST["signupUserName"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["signupUserName"] ) ){
			
			$signupUserNameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupUserName = $_POST["signupUserName"];
			
		}
		
	} 
	
	// on üldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia jõuan siis kui parool oli olemas - isset
			// parool ei olnud tühi -empty
			
			// kas parooli pikkus on väiksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
		
	}
	
	// on üldse olemas selline muutja
	if( isset( $_POST["firstname"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["firstname"] ) ){
			
			$firstnameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$firstname = $_POST["firstname"];
			
		}
		
	} 
	
	// on üldse olemas selline muutja
	if( isset( $_POST["lastname"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["lastname"] ) ){
			
			$lastnameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$lastname = $_POST["lastname"];
			
		}
		
	} 
	
	
	// GENDER
	if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 
	
	// peab olema email ja parool
	// ühtegi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		// salvestame ab'i
		echo "Salvestan... <br>";
		
		//echo "email: ".$signupEmail."<br>";
		//echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		//echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		
		// KASUTAN FUNKTSIOONI
		$signupUserName = $Helper->cleanInput($signupUserName);
		$signupEmail = $Helper->cleanInput($signupEmail);
		$firstname = $Helper->cleanInput($firstname);
		$lastname = $Helper->cleanInput($lastname);
		$signupGender = $Helper->cleanInput($signupGender);
		
		$User->signUp($signupUserName, $Helper->cleanInput($password), $signupEmail, $firstname, $lastname, $signupGender);
		
		
		
	
	}
	
	
	$error ="";
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
	
		<div class="row">
		
			<div class="col-sm-4">
				<h2>Logi sisse</h2>
				<form method="POST">
					<p style="color:red;"><?=$error;?></p>
					
					<br>
					
					<div class="form-group">
						<input class="form-control" name="loginUsername" placeholder="Kasutajanimi" type="text">
					</div>
					<br><br>
					
					<input class="form-control" type="password" name="loginPassword" placeholder="Parool">
					<br><br>
					
					<input class="btn btn-success btn-sm btn-block btn-block hidden-xs" type="submit" value="Logi sisse">
					<input class="btn btn-success btn-sm btn-block btn-block visible-xs-block" type="submit" value="Logi sisse">
					
					
				</form>
			</div>
		
			<div class="col-sm-4 col-sm-offset-3">
				<h2>Loo kasutaja</h2>
				<form method="POST">
					
					
					<br>
					<input class="form-control" placeholder="Kasutajanimi" name="signupUserName" type="text" value="<?=$signupUserName;?>"> <?=$signupUserNameError;?>
					<br><br>
					
					<input class="form-control" type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
					<br><br>
					
					<input class="form-control" placeholder="E-post" name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
					<br><br>
					
					<input class="form-control" placeholder="Eesnimi" name="firstname" type="text" value="<?=$firstname;?>"> <?=$firstnameError;?>
					<br><br>
					
					<input class="form-control" placeholder="Perenimi" name="lastname" type="text" value="<?=$lastname;?>"> <?=$lastnameError;?>
					<br><br>
					
					<?php if($signupGender == "male") { ?>
						<input type="radio" name="signupGender" value="male" checked> Mees<br>
					<?php }else { ?>
						<input type="radio" name="signupGender" value="male"> Mees<br>
					<?php } ?>
					
					<?php if($signupGender == "female") { ?>
						<input type="radio" name="signupGender" value="female" checked> Naine<br>
					<?php }else { ?>
						<input type="radio" name="signupGender" value="female"> Naine<br>
					<?php } ?>
					
					<?php if($signupGender == "other") { ?>
						<input type="radio" name="signupGender" value="other" checked> Muu<br>
					<?php }else { ?>
						<input type="radio" name="signupGender" value="other"> Muu<br>
					<?php } ?>
					
					<br><br>
					<input type="submit" class="btn btn-primary btn-sm btn-block hidden-xs" value="Loo kasutaja">
					<input type="submit" class="btn btn-primary btn-sm btn-block visible-xs-block" value="Loo kasutaja">
				
			</div>


	
	
	
	
		
			</form>
	</div>
	</div>
	
<?php require("../partials/footer.php"); ?>

