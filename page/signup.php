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
	$phoneNumber = "";
	$dateOfBirth = "";
	$dateOfBirthError = "";
	$saved = "";
	$baptised ="";

	// on ¸ldse olemas selline muutja
	if( isset( $_POST["signupUserName"] ) ){
		
		//jah on olemas
		//kas on t¸hi
		if( empty( $_POST["signupUserName"] ) ){
			
			$signupUserNameError = "See v√§li on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupUserName = $_POST["signupUserName"];
			
		}
		
	} 
	
	// on ¸ldse olemas selline muutja
	if( isset( $_POST["signupEmail"] ) ){
		
		//jah on olemas
		//kas on t¸hi
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See v√§li on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			// siia jıuan siis kui parool oli olemas - isset
			// parool ei olnud t¸hi -empty
			
			// kas parooli pikkus on v‰iksem kui 8 
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema v√§hemalt 8 t√§hem√§rkki pikk";
			
			}
			
		}
		
	}
	
	// on ¸ldse olemas selline muutja
	if( isset( $_POST["firstname"] ) ){
		
		//jah on olemas
		//kas on t¸hi
		if( empty( $_POST["firstname"] ) ){
			
			$firstnameError = "See v√§li on kohustuslik";
			
		} else {
			
			// email olemas 
			$firstname = $_POST["firstname"];
			
		}
		
	} 
	
	// on ¸ldse olemas selline muutja
	if( isset( $_POST["lastname"] ) ){
		
		//jah on olemas
		//kas on t¸hi
		if( empty( $_POST["lastname"] ) ){
			
			$lastnameError = "See v√§li on kohustuslik";
			
		} else {
			
			// email olemas 
			$lastname = $_POST["lastname"];
			
		}
		
	} 
	
	if( isset( $_POST["phonenumber"] ) ){
		
		$phoneNumber = $_POST["phonenumber"];
			
		
	} 
	
	
	if( isset( $_POST["dateOfBirth1"] ) ){
		
		if( empty( $_POST["dateOfBirth3"] ) ){
		
			$dateOfBirthError = " V√§ljad on kohustuslikud!";
			
		} else {
			
			$dateOfBirth1 = $_POST["dateOfBirth1"];
			$dateOfBirth2 = $_POST["dateOfBirth2"];
			$dateOfBirth3 = $_POST["dateOfBirth3"];
			
			$dateOfBirth = $dateOfBirth3."-".$dateOfBirth2."-".$dateOfBirth1;
			
		}
		
	} 
	
	
	if( isset( $_POST["saved3"] ) ){
		
		$saved1 = $_POST["saved1"];
		$saved2 = $_POST["saved2"];
		$saved3 = $_POST["saved3"];
			
		$saved = $saved3."-".$saved2."-".$saved1;
			
		
		
	} 
	
	
	
	if( isset( $_POST["baptised3"] ) ){
		
		$baptised1 = $_POST["baptised1"];
		$baptised2 = $_POST["baptised2"];
		$baptised3 = $_POST["baptised3"];
			
		$baptised = $baptised3."-".$baptised2."-".$baptised1;
			
		
		
	} 
	
	
	
	
	
	
	// peab olema email ja parool
	// ¸htegi errorit
	
	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 isset( $_POST["firstname"]) &&
		 isset( $_POST["lastname"]) &&
		 isset( $_POST["dateOfBirth3"]) &&
		 
		 $signupEmailError == "" && 
		 $firstnameError == "" && 
		 $lastnameError == "" && 
		 $dateOfBirthError == "" && 
		 
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
		$phoneNumber = $Helper->cleanInput($phoneNumber);
		$dateOfBirth = $Helper->cleanInput($dateOfBirth);
		$saved = $Helper->cleanInput($saved);
		$baptised = $Helper->cleanInput($baptised);
		
		
		
		
		$User->signUp($signupEmail, $Helper->cleanInput($password), $signupUserName, $firstname, $lastname, $phoneNumber, $dateOfBirth, $saved, $baptised);
		
		
	
	}
	
	
	

?>

<?php require("../partials/header.php"); ?>

	<div class="container">
	
		<div class="row" >
		
		
			<div class="col-sm-6 col-sm-offset-3">
				<h2>Loo kasutaja</h2>
				<form method="POST">
					
					<br><br>
					<input class="form-control" placeholder="E-post" name="signupEmail" type="text" value="<?=$signupEmail;?>"> <?=$signupEmailError;?>
					<br><br>
					
					<input class="form-control" type="password" name="signupPassword" placeholder="Parool"> <?php echo $signupPasswordError; ?>
					<br><br>
					
					<input class="form-control" placeholder="Kasutajanimi" name="signupUserName" type="text" value="<?=$signupUserName;?>">
					<br><br>
					
					<input class="form-control" placeholder="Eesnimi" name="firstname" type="text" value="<?=$firstname;?>"> <?=$firstnameError;?>
					<br><br>
					
					<input class="form-control" placeholder="Perenimi" name="lastname" type="text" value="<?=$lastname;?>"> <?=$lastnameError;?>
					<br><br>
					
					<input class="form-control" placeholder="Telefon" name="phonenumber" type="text" value="<?=$phoneNumber;?>">
					<br><br>
					
					<label for="dateOfBirth1">S√ºnnikuup√§ev</label><?php echo $dateOfBirthError;?>
					<br>
					<div class="form-group col-xs-4">
					  <select class="form-control" name="dateOfBirth1"> 
						<option selected>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					  </select>
					</div>
					
					<div class="form-group col-xs-4">
					  <select class="form-control" name="dateOfBirth2">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option selected>12</option>
					  </select>
					</div>
					
					<div class="col-xs-4">
					<input class="form-control"  name="dateOfBirth3" placeholder="1990" type="text">
					</div>
					<br><br><br>
					
					<label for="saved1">P√§√§stetud</label>
					<br>
					<div class="form-group col-xs-4">
					  <select class="form-control" name="saved1">
						<option selected>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					  </select>
					</div>
					
					<div class="form-group col-xs-4">
					  <select class="form-control" name="saved2">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option selected>12</option>
					  </select>
					</div>
					
					<div class="col-xs-4">
					<input class="form-control"  name="saved3" placeholder="1990" type="text"> 
					</div>
					<br><br><br>
					
					<label for="baptised1">Ristitud</label>
					<br>
					<div class="form-group col-xs-4">
					  <select class="form-control" name="baptised1">
						<option selected>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
						<option>13</option>
						<option>14</option>
						<option>15</option>
						<option>16</option>
						<option>17</option>
						<option>18</option>
						<option>19</option>
						<option>20</option>
						<option>21</option>
						<option>22</option>
						<option>23</option>
						<option>24</option>
						<option>25</option>
						<option>26</option>
						<option>27</option>
						<option>28</option>
						<option>29</option>
						<option>30</option>
						<option>31</option>
					  </select>
					</div>
					
					<div class="form-group col-xs-4">
					  <select class="form-control" name="baptised2">
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
						<option>5</option>
						<option>6</option>
						<option>7</option>
						<option>8</option>
						<option>9</option>
						<option>10</option>
						<option>11</option>
						<option selected>12</option>
					  </select>
					</div>
					
					<div class="col-xs-4">
					<input class="form-control"  name="baptised3" placeholder="1990" type="text">
					</div>
					<br><br><br><br>
					
					
				
					
					
			
					<input type="submit" class="btn btn-success btn-sm btn-block hidden-xs" value="Loo kasutaja">
					<input type="submit" class="btn btn-success btn-sm btn-block visible-xs-block" value="Loo kasutaja">
				
					<br>
					
				
				</form>
			
			
					<form action="login.php">
						<input type="submit" class="btn btn-info btn-sm btn-block btn-block hidden-xs" value="Kasutaja juba olemas?">
						<input type="submit" class="btn btn-info btn-sm btn-block btn-block visible-xs-block" value="Kasutaja juba olemas?">
					</form>
					<br>
					<br>
				
				
			</div>

			
	
	
	
	
		
			</form>
	</div>
	</div>
	
<?php require("../partials/footer.php"); ?>



