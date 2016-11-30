<?php 
	
	require("../functions.php");
	
	require("../class/User.class.php");
	$User = new User($link);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();
	
	// kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
		//suunan sisselogimise lehele
		header("Location: data.php");
		exit();
		
	}
	


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
	$dateOfBirth = "";
	$dateOfBirthError = "";
	$saved = "";
	$baptised ="";

	// on üldse olemas selline muutja
	if( isset( $_POST["signupUserName"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["signupUserName"] ) ){
			
			$signupUserNameError = "See vÃ¤li on kohustuslik";
			
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
			
			$signupEmailError = "See vÃ¤li on kohustuslik";
			
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
				
				$signupPasswordError = "Parool peab olema vÃ¤hemalt 8 tÃ¤hemÃ¤rkki pikk";
			
			}
			
		}
		
	}
	
	// on üldse olemas selline muutja
	if( isset( $_POST["firstname"] ) ){
		
		//jah on olemas
		//kas on tühi
		if( empty( $_POST["firstname"] ) ){
			
			$firstnameError = "See vÃ¤li on kohustuslik";
			
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
			
			$lastnameError = "See vÃ¤li on kohustuslik";
			
		} else {
			
			// email olemas 
			$lastname = $_POST["lastname"];
			
		}
		
	} 
	
	// on ð¬¤³e olemas selline muutja
	if( isset( $_POST["dateOfBirth"] ) ){
		
		//jah on olemas
		//kas on tð¨©
		if( empty( $_POST["dateOfBirth"] ) ){
			
			$dateOfBirthError = "See vÃ¤li on kohustuslik";
			
		} else {
			
			// email olemas 
			$dateOfBirth = $_POST["dateOfBirth"];
			
		}
		
	} 
	
	
	if( isset( $_POST["saved"] ) ){
		
		
		$saved = $_POST["saved"];
			
		
		
	} 
	
	if( isset( $_POST["baptised"] ) ){
		
		
		$baptised = $_POST["baptised"];
			
		
		
	} 
	
	
	// on ð¬¤³e olemas selline muutja
	if( isset( $_POST["dateOfBirth"] ) ){
		
		//jah on olemas
		//kas on tð¨©
		if( empty( $_POST["dateOfBirth"] ) ){
			
			$dateOfBirthError = "See vÃ¤li on kohustuslik";
			
		} else {
			
			// email olemas 
			$dateOfBirth = $_POST["dateOfBirth"];
			
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
		$dateOfBirth = $Helper->cleanInput($dateOfBirth);
		$saved = $Helper->cleanInput($saved);
		$baptised = $Helper->cleanInput($baptised);
		
		
		
		
		$User->signUp($signupUserName, $Helper->cleanInput($password), $signupEmail, $firstname, $lastname, $dateOfBirth, $saved, $baptised);
		
		
		
	
	}
	
	
	

?>

<?php require("../partials/header.php"); ?>

	<div class="container">
	
		<div class="row" >
		
		
			<div class="col-sm-4 col-sm-offset-4">
				<h2>Loo kasutaja</h2>
				<form method="POST">
					
					
					<br><br>
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
					
					<input class="form-control" placeholder="SÃ¼nniaeg" name="dateOfBirth" type="date" value="<?=$dateOfBirth;?>"> <?=$dateOfBirthError;?>
					<br><br>
					
					<input class="form-control" placeholder="PÃ¤Ã¤stetud" name="saved" type="date" value="<?=$saved;?>">
					<br><br>
					
					<input class="form-control" placeholder="Ristitud" name="baptised" type="date" value="<?=$baptised;?>">
					<br><br>
					
					
			
					<input type="submit" class="btn btn-primary btn-sm btn-block hidden-xs" value="Loo kasutaja">
					<input type="submit" class="btn btn-primary btn-sm btn-block visible-xs-block" value="Loo kasutaja">
				
			</div>


	
	
	
	
		
			</form>
	</div>
	</div>
	
<?php require("../partials/footer.php"); ?>

