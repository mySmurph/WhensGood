<!--  http://cis444.cs.csusm.edu/group4/WhensGood/enter-schedule_event.html -->
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
	printNavigtion();
	?>
  
    <main id="main">
        <h1>
            Lets put it on the schedule...
        </h1>
        
    <!--actual container centers within container-->
		<form class="alert" action="schedule_event_org_view.html">
			<ul>
				<li>
					<label>Enter Event Code<br />
					<input type="text" class="text_input full" id="event_code"/></label>
				</li>
				<li>
					<label>Enter Event Password<br/>
					<input id="password_input" type="password" class="text_input full"/></label>
				</li>
			</ul>
				<div>
					<button class="button red span" id = "button">Submit</button><br/>
				</div>
		</form>
	</main>
	<script type="text/javascript" src="script/enter_schedule_event.js"></script>
</body>
</html>