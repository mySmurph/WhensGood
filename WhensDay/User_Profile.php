<?php
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/DB_Controller.php");
	include ("../PHP_Functions/functions.php");

	$db = new DB_Controller();
	$return = "../WhensDay/User_Login.php";

	if(!isset($_SESSION["user"]) || !($_SESSION["user"] instanceof User)){

		if( isset($_POST["check_SignUp"]) && $_POST["check_SignUp"] == 'true'){
			//create new user
			$username = isset($_POST["username"])? $_POST["username"] : null;
			$email = isset($_POST["email"])? $_POST["email"] : null;
			$name = isset($_POST["name"])? $_POST["name"] : null;
			$pass = isset($_POST["password_1"])? $_POST["password_1"] : null;

			if(!is_null($username) && !is_null($email) && !is_null($name) && !is_null($pass)){
				//try to insert user
				$username_already_taken = $db->usernameExist($username);
				$account_exist_using_email = $db->emailExist($email);

				if(!$username_already_taken && !$account_exist_using_email){
					$user = new User($username, $name, $email);
					var_dump($user);
					if($db->insertUser($user, $pass)){
						$_SESSION["user"] = $user;
					}
				}else{
					$return .= "?&username=$username&email=$email&name=$name";
					$return .= "&usernameAvailible=".($username_already_taken?0:1);
					$return .= "&emailAvailible=".($account_exist_using_email?0:1);
				}
			}
		}else{
			// echo "try to lookup user<br/>";
			//lookup user
			$userID = isset($_POST["userID"])? $_POST["userID"] : null;
			$pass = isset($_POST["password"])? $_POST["password"] : null;
			// echo "userID = $userID, pass = $pass <br/>";
			if(!is_null($userID) && !is_null($pass) ){
				//lookup user
				$username = $db->userExist($userID, $pass);
				// echo "username = $username <br/>";
				if(!is_null($username)){
					$_SESSION["user"] = $db->getUser($username);
				}
				else{
					$return .= "?userID=$userID&userFound=0";
				}
			}
		}
	}
	$user = $_SESSION["user"];

	if(!($user instanceof User)){
		// redirect
		@header("Location: $return");
		echo "
			<script type=\"text/javascript\">
				window.location.href = $return;
			</script>
		";
	}

?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('User Profile');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1>
			<span id = 'h1'>
				User Profile
			</span>
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
		</h1>
			<div class = "scrollable">

				<div class = "grid_container_set_auto" >
					<!-- profile access buttons -->
					<div id = "btn_">
						<button class = "span" id = "btn_profile">Profile Details</button>
						<button class = "span" id = "btn_edit_profile">Edit Profile</button>
						<button class = "span" id = "btn_my_events">My Events</button>
						<button class = "span" id = "btn_my_rsvps">My RSVP's</button>
					</div>
					<!-- sections -->
					<div id = "div_" >
						<div id = "div_profile" class = "profileSection" >
							<h2>Hello <?php echo $user->getDisplayName(); ?>! Whats on the schedule for today?</h2>
							< mayber a notification saction here ? >
						</div>
						<!-- update user information -->
						<div id = "div_edit_profile" class = "profileSection" >
							<h2>Edit Profile</h2>
								<div  class = "grid_container_flexable " >
								<form id = "from_update_user">
									<ul>
										<li>
											<label>Display Name</label>
											<input type = "text" class = "full" id = "name" name = "name" />
										</li>
										<li>
											<label>Email</label>
											<input type = "text" class = "full" id = "email" name = "email" />
										</li>
									</ul>
									<button class = "red small span" id = "btn_update_user">Save Changes</button>
								</form>

								<form id = "form_update_password">
									<ul>
										<li>
											<label>Current Password</label>
											<input type = "password" class = "input_type_text full" id = "current_password" name = "current_password" />
										</li>
										<li>
											<label>New Password</label>
											<input type = "password" class = "input_type_text full" id = "password_1" name = "password_1" />
										</li>
										<li>
											<label>Confirm Password</label>
											<input type = "password" class = "input_type_text full" id = "password_2" name = "password_2" />
										</li>
									</ul>
									<button class = "red small span" id = "btn_update_password">Update Password</button>
								</form>
							</div>
						</div>
						<!-- my events -->
						<div id = "div_my_events"  class = "profileSection" >
							<h2>My Events</h2>
							<form id = "my_events">
								<?php
									foreach($user->getEvents() as &$event){
										$code = $event->getCode();
										$title = $event->getTitle();
										$start = toString($event->getStartDate());
										$end = toString($event->getEndDate());
										echo "<button id = '$code' name = '$code'>
											$title
												<span class = 'label'>
												$code&nbsp;&nbsp;&#10072;&nbsp;&nbsp;$start&nbsp;&dash;&nbsp;$end
												</class>
											</button>";
									}
									unset($event);
								?>
								<input type = "text" class = "POST_info" id = "gotoThisEvent" name = "gotoThisEvent" value = "" readonly/>
							</form>
							</div>
						<!-- events i'm invited to -->
						<div id = "div_my_rsvps"  class = "profileSection" >
							<h2>RSVP's</h2>
							active RSVP's go here
						</div>
					</div>
				</div>

				<?php
				 //$user->var_dump(); 
				 ?>
			</div>
	</main>
	<script type="text/javascript">

		var btn_s = Array.from(document.getElementById('btn_').children);
		var div_s = Array.from(document.getElementById('div_').children);
		var my_events = Array.from(document.getElementById('my_events').children);
		
		

		btn_s.forEach(b => b.addEventListener('click', function(){showSection(this);}));
		my_events.forEach(e => e.addEventListener('click', function(){gotoThisEvent(this);}));

		function hideSections(){
			div_s.forEach(d => d.style.display = "none" );
		}
		function showSection(btn){
			hideSections();
			var div_id = btn.id.replace("btn", "div");
			document.getElementById(div_id).style.display = "block";
		}
		showSection(btn_s[0]);

		function gotoThisEvent(event){
			document.getElementById('gotoThisEvent').value = event.id;
			var form = document.getElementById('my_events');
			form.method = "POST";
			form.action = "ScheduleEvent.php";
			form.submit();
		}
	</script>

</body>
</html>