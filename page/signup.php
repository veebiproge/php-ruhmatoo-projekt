<?php 
	
	require("../functions.php");
	
	require("../class/User.class.php");
	$User = new User($link);
	
	require("../class/Helper.class.php");
	$Helper = new Helper();

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

	// muutuja kontroll
	if( isset( $_POST["signupUserName"] ) ){
	
		if( empty( $_POST["signupUserName"] ) ){
			
			$signupUserNameError = "See väli on kohustuslik";
			
		} else {
			
			$signupUserName = $_POST["signupUserName"];
			
		}
		
	} 
	
	if( isset( $_POST["signupEmail"] ) ){
		
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	
	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
		
	}
	
	if( isset( $_POST["firstname"] ) ){
		
		if( empty( $_POST["firstname"] ) ){
			
			$firstnameError = "See väli on kohustuslik";
			
		} else {
			
			$firstname = $_POST["firstname"];
			
		}
		
	} 
	
	if( isset( $_POST["lastname"] ) ){
		
		if( empty( $_POST["lastname"] ) ){
			
			$lastnameError = "See väli on kohustuslik";
			
		} else {
			
			$lastname = $_POST["lastname"];
			
		}
		
	} 
	
	if( isset( $_POST["phonenumber"] ) ){
		
		$phoneNumber = $_POST["phonenumber"];	
		
	} 
	
	if( isset( $_POST["dateOfBirth1"] ) ){
		
		if( empty( $_POST["dateOfBirth3"] ) ){
		
			$dateOfBirthError = " Sünnikuupäev on kohustuslik!";
			
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
	
	// muutujate olemasolu kontroll
	// vaatab ka, et ei oleks ühtegi errorit
	
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
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
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
			<br>
			<h4><span class="asterisk_input">  </span> - väljad on kohustuslikud</h4>
			
				<form method="POST">
					
					<br><br>
					<span class="asterisk_input">  </span> 
					<input class="form-control" placeholder="E-post" name="signupEmail" type="text" value="<?=$signupEmail;?>" > <p style="color:red;"><?=$signupEmailError;?></p> 
					<br><br>
					
					<span class="asterisk_input">  </span> 
					<input class="form-control" type="password" name="signupPassword" placeholder="Parool"> <p style="color:red;"><?php echo $signupPasswordError; ?></p> 
					<br><br>
					
					<input class="form-control" placeholder="Kasutajanimi" name="signupUserName" type="text" value="<?=$signupUserName;?>">
					<br><br>
					
					<span class="asterisk_input">  </span> 
					<input class="form-control" placeholder="Eesnimi" name="firstname" type="text" value="<?=$firstname;?>"> <p style="color:red;"><?=$firstnameError;?></p> 
					<br><br>
					
					<span class="asterisk_input">  </span> 
					<input class="form-control" placeholder="Perenimi" name="lastname" type="text" value="<?=$lastname;?>"> <p style="color:red;"><?=$lastnameError;?></p> 
					<br><br>
					
					<input class="form-control" placeholder="Telefon" name="phonenumber" type="text" value="<?=$phoneNumber;?>">
					<br><br>
					
					<span class="asterisk_input">  </span> 
					<label for="dateOfBirth1">Sünnikuupäev</label><p style="color:red;"><?php echo $dateOfBirthError;?></p> 
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
					
					<label for="saved1">Päästetud</label>
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
			
				<?php if(!isset($_SESSION["userId"])) {
					
					$html = "<form action='login.php'>";
						$html .= "<input type='submit' class='btn btn-info btn-sm btn-block btn-block hidden-xs' value='Kasutaja juba olemas?'>";
						$html .= "<input type='submit' class='btn btn-info btn-sm btn-block btn-block visible-xs-block' value='Kasutaja juba olemas?'>";
					$html .= "</form>";
					$html .= "<br><br>";
					echo $html;
					
				} ?>
				
			</div>

		</div>
		
	</div>
	
<?php require("../partials/footer.php"); ?>