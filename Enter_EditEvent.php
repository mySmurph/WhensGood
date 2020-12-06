<?php
	session_start();
?>
<!--  https://cis444.cs.csusm.edu/group4/WhensGood/Enter_EditEvent.php-->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
	<title>Edit Event</title> 
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>

<body>

	<?php 
	include ("functions.php");
	printNavigation();
	?>
	
  
    <main id="main">
        <h1>
            Let's see if we can make it work...
        </h1>
<?php 

	$eventFound = $_SESSION['eventFound'];
	$code = $_SESSION['event_code'];
	if(isset($eventFound) && !$eventFound){
		echo "<div class = \"alert_message\">The event code '$code' not found. / The password you’ve entered is incorrect.</div>";
	}
	unset($_SESSION['eventFound']);
	unset($_SESSION['event_code']);
	session_destroy();

?>
    <!--actual container centers within container-->
	<form  class="alert" id = "Enter_form">
			<ul>
				<li>
					<label>Enter Event Code<br />
					<input type="text" class="text_input full" name="event_code" id="event_code"/></label>
				</li>
				<li>
					<label>Enter Event Password<br/>
					<input name="password_input" id="password_input" type="password" class="text_input full"/></label>
				</li>
			</ul>
			<div>
				<button class="button red span" id = "Enter_Form_Button">Submit</button><br />
			</div>
			<div class = "POST_info" >
				<input type = "text" aria-label="source" name = "source" value = "Enter_EditEvent.php" readonly />
				<input type = "text" aria-label="destination" name = "destination" value = "CreateEvent.php" readonly />
			</div>
		</form>
	</main>
	<!-- <script type="text/javascript" src="script/enter_edit_event.js"></script> -->
	<script type="text/javascript" src="script/hub.js"></script>
</body>
</body>
</html>