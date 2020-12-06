<?php
	session_start();
	// var_dump($_SESSION);
?>
<!--  https://cis444.cs.csusm.edu/group4/WhensGood/ScheduleEvent.php -->

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
	<title>Finalize Event Page</title> 
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
	
<?php 
	include ("functions.php");
	printNavigation();

	echo '<main id="main">';

	if(isset($_SESSION["eventFound"]) && isset($_SESSION["event_code"]) && $_SESSION["eventFound"]){
		$code = $_SESSION["event_code"];

		echo	'<h1> Schedule Event <span class="h1EventCode"> '.$code.' </span> </h1>
				<form id = "Schedule_form">
					<div class="grid_container">
						<div>
							<label> Event Windows</label>
							<a href="CreateEvent.php" class = "note">[Edit Event]</a>';
							//<!-- <span class = "feedback" id = "StartDate">11-1-2020</span> -->

		$eventWindow = getEventWindow($code);
		$eventMask = getEventMask($code);

		$eventWindow = DateWindows::eventToBoolWeek($eventWindow);
		$eventMask = DateWindows::eventToBoolWeek($eventMask);
		DateWindows::printCalendarMaskedBlock($eventWindow, $eventMask);
echo '
				</div>
				<div>
					<label>Event Participants</label><br/>
						<ul class="white full">
							<li>
								Accept
								<ul id = "accept" class = "participant_List">
									<li>
										name 1
									</li>
									<li>
										name 3
									</li>
									<li>
										name 4
									</li>
								</ul>
							</li>
							<li>
								Decline
								<ul id = "decline" class = "participant_List">
									<li>
										name 2
									</li>
								</ul>
							</li>
						</ul>
					
				</div>

            
		</div>
		<button type="submit" class="button span red" id = "button">Schedule Event</button>
	</form>
	

<script type="text/javascript" src="script/schedule_event.js"></script>';
	}
	else{
		echo	'
			<h1> Schedule Event </h1>
			<div class = "alert_message">Somthing went wrong.</div>
		';
	}
	// session_destroy();
?>
</main>
</body>
</html>