<?php
	  if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	$_SESSION['access'] = false;
	$printAlert = (isset($_GET['found']) && intval($_GET['found']) == 0)? TRUE : FALSE;
?>
<!-- https://cis444.cs.csusm.edu/group4/WhensGood/Enter_RSVP.php -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
  <title>RSVP View</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>

<body class = "grid_container_set_auto">
	<?php 
	include ("../PHP_Functions/functions.php");
	printNavigation();
	?>
	
    <main id="main">
        <h1>
            I'll check my schedule...
        </h1>

	<?php 

$code = isset($_SESSION['event_code']) ? $_SESSION['event_code'] : '';
if($printAlert){
	echo "<div class = \"alert_message\">The event code '$code' not found. / The password you’ve entered is incorrect.</div>";
}
unset($_SESSION['eventFound']);
unset($_SESSION['event_code']);
session_destroy();


	?>
		<form class="alert" id = "Enter_form">
			<ul>
				<li>
					<label>Enter Event Code<br />

					<input type="text" class="input_type_text full" name = "event_code" id="event_code"/></label>
					
					<!-- Valid Value -->
					<!-- <input type="text" class="input_type_text full" name = "event_code" id="event_code" value = "1kxeqfw3ce"/></label> -->
				</li>
				<li>
					<div class="switchbox">
						<div class = "label">Participant</div>
						<input type="checkbox" id="switchbox" data-check-switch aria-label="rsvp" uncheked/>
						<div class = "label">Orgainizer</div>
					</div>
				</li>
				<li>
					<div class="password_container" id = "password_container">
						<label>Enter Event Password<br/>
						<input name = "password_input" id="password_input" type="password" class="input_type_text full"/></label>
					</div>
				</li>
			</ul>
				<div>
					<button type="submit" class="button red span" id="Enter_Form_Button" >Submit</button><br />
				</div>
				<div class = "POST_info" >
					<input type = "text" aria-label="source" name = "source" value = "Enter_RSVP.php" readonly />
					<input type = "text" aria-label="destination" name = "destination" value = "RSVP.php" readonly />
				</div>
		</form>
    </main>
	<!-- <script type="text/javascript" src="../script/enter_rsvp.js"></script> -->
	<script type="text/javascript" src="../script/hub.js"></script>
</body>
</html>