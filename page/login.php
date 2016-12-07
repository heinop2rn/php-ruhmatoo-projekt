<?php
	//v?µtab ja kopeerib faili sisu
	require("../functions.php");
	
	require("../class/User.class.php");
	$User = new User($mysqli);
	
	require("../class/Helper.Class.php");
	$Helper = new Helper($mysqli);
	
	//kas kasutaja on sisse logitud
	if (isset($_SESSION["userId"])) {
		
		header("Location: data.php");
	}	
	//var_dump(5.5);
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	
// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupPassword = "";
	$signupEmail = "";
	$name = "";
	$nameError = "";
	$loginUsername = "";
	$loginUsernameError = "";
	$loginPasswordError = "";
	$loginError = "";
	$Saved_Email = "";
	$loginEmail = "";
	$loginEmailAnswer = "";
	$loginEmailError = "";
	$gender = "male";
	
$loginUsernameAnswer = (isset($_POST['loginUsername'])) ? $_POST['loginUsername'] : '';
$signupUsernameAnswer = (isset($_POST['signupUsername'])) ? $_POST['signupUsername'] : '';
$signupEmailAnswer = (isset($_POST['signupEmail'])) ? $_POST['signupEmail'] : '';
$signupNameAnswer = (isset($_POST['signupName'])) ? $_POST['signupName'] : '';
	
	if(isset($_POST["loginUsername"])){
		if(empty($_POST["loginUsername"])){
			$loginUsernameError="<i>Palun sisesta kasutajanimi!</i>";
		}
	}
	
	if(isset($_POST["loginPassword"])){
		if(empty($_POST["loginPassword"])){
			$loginPasswordError="<i>Palun sisesta parool!</i>";
		}
	}
	
	
	// kas e/post oli olemas
	if ( isset ( $_POST["signupUsername"] ) ) {
		
		if ( empty ( $_POST["signupUsername"] ) ) {
			
			// oli kasutajanimi, kuid see oli tühi
			$signupEmailError = "<i>Palun sisesta enda kasutajanimi!</i>";
			
		} else {
			
			// email on ?µige, salvestan v?¤?¤rtuse muutujasse
			$signupEmail = $_POST["signupUsername"];
			
		}
		
	}
	if ( isset ( $_POST["signupEmail"] ) ) {
		
		if ( empty ( $_POST["signupEmail"] ) ) {
			
			// oli email, kuid see oli tühi
			$signupEmailError = "<i>Please write your email!</i>";
			
		} else {
			
			// email on ?µige, salvestan v?¤?¤rtuse muutujasse
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	}
	
	if ( isset ( $_POST["signupPassword"] ) ) {
		
		if ( empty ( $_POST["signupPassword"] ) ) {
			
			// oli password, kuid see oli t?¼hi
			$signupPasswordError = "<i>Palun sisesta parool!</i>";
			
		} else {
			
			// tean et parool on ja see ei olnud t?¼hi
			// V?„HEMALT 8
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "<i>Minimaalne parooli pikkus - 8 tähemärki!</i>";
				
				
			}
			
		}
		
	}
	
	if ( isset ( $_POST["signupName"] ) ) {
		
		if ( empty ( $_POST["signupName"] ) ) {
			
			$nameError = "<i>Please write your name!</i>";
		
		} 
	}
	
	
	
	
	if ( isset ( $_POST["role"] ) ) {
		if ( empty ( $_POST["role"] ) ) {
			$roleError = "<i>Palun vali kas oled fotograaf või klient!</i>";
		} else {
			$role = $_POST["role"];
		}
	}
	
	
	//Kus tean et ?¼htegi viga ei olnud ja saan kasutaja andmed salvestada
	if ( isset($_POST["signupPassword"]) &&
		 isset($_POST["signupEmail"]) &&	
		 isset($_POST["signupName"]) &&
		 empty($signupPasswordError) &&
		 empty($signupEmailError) && 
		 empty($nameError)
		 
	   ) {
		
		echo " ";
		#echo "email ".$signupEmail."<br>";
		
		echo " ";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		$signupName=($_POST['signupName']);
		
		#echo "parool ".$_POST["signupPassword"]."<br>";
		#echo "r?¤si ".$password."<br>";
		
		
	
		$signupEmail = cleanInput($signupEmail);
		$password = cleanInput($password);
		
		signup($signupEmail, $password, $signupName);
	   
	}
	
	$error = "";
	// kontrollin, et kasutaja t?¤itis v?¤ljad ja v?µib sisse logida
	if ( isset($_POST ["loginEmail"]) &&
		 isset($_POST ["loginPassword"]) &&
		 !empty($_POST["loginEmail"]) &&
		 !empty($_POST["loginPassword"])
	  )	{
		
		$Saved_Email = $_POST["loginEmail"];	
		
		//login sisse
		$error = $User->login($Helper->cleanInput($_POST["loginEmail"]), $Helper->cleanInput($_POST["loginPassword"]));
	
	}
	
?>
<?php require("../partials/header.php");?>

	<div class="container">
		<div class="row">
			
			<div class="col-sm-4 col-md-3">
			<h1>Logi sisse</h1>

		
		<form method="POST">
			<p style="Shipping:red;"><?=$error;?></p>
			<div class="form-group">
			<input class="form-control" name="Email" type="text" placeholder="E-post" value="<?php print $loginEmailAnswer; ?>"> <?php echo $loginEmailError; ?>
			</div>
				
			<div class="form-group">
			<input class="form-control" name="loginPassword" type="password" placeholder="Password"> <?php echo $loginPasswordError; ?>
			</div>
			
		
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Logi sisse">
			<input class="btn btn-success btn-sm btn-block visible-xs-block" type="submit" value="Logi sisse">
			
		</form>
			</div>
			
			<div class="col-sm-4 col-md-3 col-sm-offset-4 col-md-offset-3">
			<h1>Loo uus kasutaja</h1>
		
		<form method="POST">
		
			<div class="form-group">
			<input class="form-control" type="text" name="signupName" placeholder="Ees- ja perekonnanimi" value="<?php print $signupNameAnswer;?>"> <?php echo $nameError; ?>
			</div>
			
			<div class="form-group">
			<input class="form-control" name="signupPassword" type="password" placeholder="Password"> <?php echo $signupPasswordError; ?>
			</div>
			
			<div class="form-group">
			<input class="form-control" name="signupEmail" type="email" placeholder="E-Post" value="<?php print $signupEmailAnswer;?>"> <?php echo $signupEmailError; ?>
			</div>
		
			
			 <?php if($role == "photographer") { ?>
				<input type="radio" name="role" value="photographer" checked>  Olen fotograaf<br> 
			 <?php } else { ?>
				<input type="radio" name="role" value="photographer" >  Olen fotograaf<br>
			 <?php } ?>
			 
			 <?php if($role == "client") { ?>
				<input type="radio" name="role" value="client" checked>  Otsin fotograafi<br>
			 <?php } else { ?>
				<input type="radio" name="role" value="client" >  Otsin fotograafi<br>
			 <?php } ?>
			<br>
	
			<input class="btn btn-success btn-sm hidden-xs" type="submit" value="Loo kasutaja">
			<input class="btn btn-success btn-sm btn-block visible-xs-block" type="submit" value="Loo kasutaja">
			
		</form>
		
	</body>
			</div>
			
</html>
	</div>
		</div>
<?php require("../partials/footer.php");?>