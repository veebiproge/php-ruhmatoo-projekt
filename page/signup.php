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

	// on �ldse olemas selline muutja
	if( isset( $_POST["signupUserName"] ) ){
		
		//jah on olemas
		//kas on t�hi
		if( empty( $_POST["signupUserName"] ) ){
			
			$signupUserNameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupUserName = $_POST["signupUserName"];
			
		}
		
	} 
	
	// on �ldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on t�hi
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
			
			// siia j�uan siis kui parool oli olemas - isset
			// parool ei olnud t�hi -empty
			
			// kas parooli pikkus on v�iksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
		
	}
	
	// on �ldse olemas selline muutja
	if( isset( $_POST["firstname"] ) ){
		
		//jah on olemas
		//kas on t�hi
		if( empty( $_POST["firstname"] ) ){
			
			$firstnameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$firstname = $_POST["firstname"];
			
		}
		
	} 
	
	// on �ldse olemas selline muutja
	if( isset( $_POST["lastname"] ) ){
		
		//jah on olemas
		//kas on t�hi
		if( empty( $_POST["lastname"] ) ){
			
			$lastnameError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$lastname = $_POST["lastname"];
			
		}
		
	} 
	
	// on 𬤳e olemas selline muutja
	if( isset( $_POST["dateOfBirth"] ) ){
		
		//jah on olemas
		//kas on t𨩍
		if( empty( $_POST["dateOfBirth"] ) ){
			
			$dateOfBirthError = "See väli on kohustuslik";
			
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
	
	
	// on 𬤳e olemas selline muutja
	if( isset( $_POST["dateOfBirth"] ) ){
		
		//jah on olemas
		//kas on t𨩍
		if( empty( $_POST["dateOfBirth"] ) ){
			
			$dateOfBirthError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$dateOfBirth = $_POST["dateOfBirth"];
			
		}
		
	} 
	
	
	
	// peab olema email ja parool
	// �htegi errorit
	
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
					
					<input class="form-control" placeholder="Sünniaeg" name="dateOfBirth" type="date" value="<?=$dateOfBirth;?>"> <?=$dateOfBirthError;?>
					<br><br>
					
					<input class="form-control" placeholder="Päästetud" name="saved" type="date" value="<?=$saved;?>">
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

