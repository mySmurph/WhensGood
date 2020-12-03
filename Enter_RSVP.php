<!-- https://cis444.cs.csusm.edu/group4/WhensGood/Enter_RSVP.php -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
  <title>RSVP View</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>

<body>
	<?php 
	include ("functions.php");
	printNavigtion();
	?>
	
    <main id="main">
        <h1>
            I'll check my schedule...
        </h1>
        
    <!--actual container centers within container-->
		<form class="alert" action="RSVP.php">
			<ul>
				<li>
					<label>Enter Event Code<br />
					<input type="text" class="text_input full" id="event_code"/></label>
				</li>
				<li>
					<div class="switchbox">
						<div class = "label">Participant</div>
						<input type="checkbox" id="switchbox" data-check-switch aria-label="rsvp"/>
						<div class = "label">Orgainizer</div>
					</div>
				</li>
				<li>
					<div class="password_container" id = "password_container">
						<label>Enter Event Password<br/>
						<input id="password_input" type="text" class="text_input full"/></label>
					</div>
				</li>
			</ul>
				<div>
					<button class="button red span" id="button">Submit</button><br />
				</div>
		</form>
    </main>
    <script type="text/javascript" src="script/rsvp_view.js"></script>
</body>
</html>