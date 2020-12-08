<?php
	// if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	// $access = $_GET['access'] != NULL? boolval($_GET['access']): true;
	$access = true;
	if(isset($_SESSION['access'])){
		$access = false;
		unset($_SESSION['access']);
		session_destroy();
	}
	if(session_status() !== PHP_SESSION_ACTIVE) session_start();

?>
<!--  http://cis444.cs.csusm.edu/group4/WhensGood/admin_portal.html  -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
  <title>Admin Portal</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>

<body>
<?php 
	include ("functions.php");
	printNavigation();

?>
  
    <main id="main">
      <h1>
        Admin Portal
	  </h1>
	  <?php
	  if(!$access){
			echo "<div class = \"alert_message\">Invalid Credentials </div>";
		}
	?>
        <form class="alert" id = "form">
			<ul>
				<li>
					<label>Admin Username<br />
					<input id = "username" type="text" class="text_input full" name = "username"/></label>
				</li>
				<li>
					<label>Admin Password<br/>
					<input id = "password" type="password" class="text_input full" name = "password"/></label>
				</li>
			</ul>
				<div>
					<button type = "submit" class="button red span" id = "admin_password_submit">Submit</button><br />
				</div>
				<div class = "POST_info" >
				<input type = "text" aria-label="source" name = "source" value = "admin_portal.php" readonly />
				<input type = "text" aria-label="destination" name = "destination" value = "admin_control.php?GO=0" readonly />
			</div>
		</form>
    </main>
  <script type="text/javascript" src="script/admin_login_validation.js"></script>
</body>
</html>