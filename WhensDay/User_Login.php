<?php
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/functions.php");

	
	// test object
	// include ("../data/object_myUser.php");

	unset($_SESSION["user"]);
	
	$userID = isset($_GET['userID']) ? $_GET['userID'] : '';
	$username = isset($_GET['username']) ? $_GET['username'] : '';
	$name = isset($_GET['name']) ? $_GET['name'] : '';
	$email = isset($_GET['email']) ? $_GET['email'] : '';
	$userFound = isset($_GET['userFound']) ? boolval($_GET['userFound']) : true;
	$usernameAvailible = isset($_GET['usernameAvailible']) ? boolval($_GET['usernameAvailible']) : true;
	$emailAvailible = isset($_GET['emailAvailible']) ? boolval($_GET['emailAvailible']) : true;
	

?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('Login');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1>
			<span id = 'h1'>
				<button id = "btn_Login" class = "active" >Login</button>
				<button id = "btn_SignUp" >Sign Up</button>
			</span>
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
				
		</h1>

		<form class = "lookup_box" id = "form_Login">
			<ul>
				<li>
					<label>Username</label>
					<input type="text" id = "userID" name = "userID" placeholder = "username, email" class = "input_type_text full" 
					value = "<?php echo $userID;?>" 
					/>
				</li>
				<li>
					<label>Password </label>
					<input type = "password" id = "password" name = "password" class = "input_type_text full" placeholder="password"/>
				</li>
			</ul>
			<input type = "button" class = "red span" name = "btn_form_Login" id = "btn_form_Login" value = "Login">
		</form>


			<form class = "lookup_box" id = "form_SignUp" style = "display : none;">
			<ul>
				<li>
					<label>Username</label>
					<input type="text" id = "username" name = "username" class = "input_type_text full" placeholder = "PlanetXprs_3000"
					value = "<?php echo $username;?>" 
					/>
				</li>
				<li>
					<label>Email</label>
					<input type="text" id = "email" name = "email" class = "input_type_text full" placeholder="HConrad@PlanetExpress.biz"
					value = "<?php echo $email;?>" 
					/>
				</li>
				<li>
					<label>Display Name</label>
					<input type="text" id = "name" name = "name" class = "input_type_text full" placeholder="Hermes Conrad"
					value = "<?php echo $name;?>" 
					/>
				</li>
				<li>
					<label>Password </label>
					<input type = "password" id = "password_1" name = "password_1" class = "input_type_text full" placeholder="password"/>
				</li>
				<li>
					<label>Verify Password </label>
					<input type = "password" id = "password_2" class = "input_type_text full" placeholder="retype password to verify"/>
				</li>
			</ul>
				<input type = "button" class = "red span" name = "btn_form_SignUp" id = "btn_form_SignUp" value = "Sign Up"/>
		</form>
		<input class = "POST_info" type="text" id = "check_SignUp" name = "check_SignUp" value = "false" readonly/>
		<span id = "alerts_go_here"></span>
	</main>
<script type="text/javascript" src="../script/ValidationTests.js"></script>
<script type="text/javascript">
	var isSignUp = document.getElementById("check_SignUp");

	var btn_Login = document.getElementById("btn_Login");
	var form_Login = document.getElementById("form_Login");
	var btn_form_Login = document.getElementById("btn_form_Login");

	var btn_SignUp = document.getElementById("btn_SignUp");
	var form_SignUp = document.getElementById("form_SignUp");
	var btn_form_SignUp = document.getElementById("btn_form_SignUp");

	btn_form_Login.addEventListener('click', function(){valid_Login()});
	btn_form_SignUp.addEventListener('click', function(){valid_SignUp()});

	btn_Login.addEventListener('click', function(){changeActiveForm(this)});
	btn_SignUp.addEventListener('click', function(){changeActiveForm(this)});

	var alerts_go_here = document.getElementById("alerts_go_here");

	function changeActiveForm(btn){
		switch(btn){
			case btn_Login: 
				if(!btn_Login.classList.contains('active')){
					btn_Login.classList.add('active');
					form_Login.style.display = 'block';

					btn_SignUp.classList.remove('active');
					form_SignUp.style.display = 'none';
					isSignUp.value = false;
				}
				break;
			case btn_SignUp: 
				if(!btn_SignUp.classList.contains('active')){
					btn_SignUp.classList.add('active');
					form_SignUp.style.display = 'block';
					
					btn_Login.classList.remove('active');
					form_Login.style.display = 'none';
					isSignUp.value = true;
				}
				break;
			default: break;
		}
	}


	function valid_Login(){
		// valid input
		var userID = document.getElementById("userID");
		var valid_userID = validUsername(userID) || validEmail(userID);
			showError(valid_userID, userID);
		var password = document.getElementById("password");
		var valid_password = validPassword(password);

		if(valid_userID && valid_password){
			POST(form_Login);
		}
	}
	
	function valid_SignUp(){
		alerts_go_here.innerHTML = '';
		// valid input
		var username = document.getElementById("username");
		var email = document.getElementById("email");
		var name = document.getElementById("name");
		var password_1 = document.getElementById("password_1");
		var password_2 = document.getElementById("password_2");

		var valid_username = validUsername(username);
		if(!valid_username){
			alerts_go_here.innerHTML += alert(valid_username, valid_username_decription);
		}
		
		var valid_email = validEmail(email);
		var valid_name = validString(name);

		var valid_passwords = validPassword(password_1) && validPassword(password_2);
		if(!valid_passwords){
			alerts_go_here.innerHTML += alert(valid_passwords, valid_password_description);
		}else{
			if(!(password_1.value === password_2.value)){
				valid_passwords = false;
				showError(valid_passwords,password_1);
				showError(valid_passwords,password_2);
				alerts_go_here.innerHTML += alert(valid_passwords, "Passwords do not match");
			}
		}
		if(valid_username && valid_email && valid_name && valid_passwords){
			POST(form_SignUp);
		}
	}

	function POST(form){
		form.action = "../WhensDay/User_Profile.php";
		form.method = "POST";
		form.submit();
	}




</script>
<?php 
	if(!$userFound){
		echo "
		<script type=\"text/javascript\">
			alerts_go_here.innerHTML += alert(false,\"User not found. Please verify that the username/email and password entered ae correct.\");
		</script>
		";
	}
	if(!$usernameAvailible){
		echo "
		<script type=\"text/javascript\">
			changeActiveForm(button_form_SignUp);
			alerts_go_here.innerHTML += alert(false,\"Username '".$username."' is already taken.\");
		</script>
		";
	}
	if(!$emailAvailible){
		echo "
		<script type=\"text/javascript\">
			changeActiveForm(button_form_SignUp);
			alerts_go_here.innerHTML += alert(false,\"An account already exist using the email '".$email."'.\");
		</script>
		";
	}
	
?>
</body>
</html>
