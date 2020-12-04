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
?>
    <main id="main">
	<h1>
		Schedule Event
	</h1>

	<form>

		<div class="grid_container">
				<div>
					<label> Event Windows</label>
					<a href="CreateEvent.php" class = "note">[Edit Event]</a>
					<span class = "feedback" id = "StartDate">11-1-2020</span>
					<?php 

	
		$eventWindow = array(
			array('20201124', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
			array('20201125', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
			array('20201126', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
			array('20201127', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
			array('20201128', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
			array('20201129', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
			array('20201130', '000000000000000000000000000000000000111111111111111111111111111111000000000000000000000000000000')
		);
		$eventMask = array(
			array('20201124', '000000000000000000000000000000000000000000000000111111111100000000000000000000000000000000000000'), 
			array('20201125', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
			array('20201126', '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
			array('20201127', '000000000000000000000000000000000000000000000000111111111111111111111111110000000000000000000000'), 
			array('20201128', '000000000000000000000000000000000111111111111111111111111111111111111111100000000000000000000000'),
			array('20201129', '000000000000000000000000000000000000111111111111111111111111111111000000000000000000000000000000'),
			array('20201130', '000000000000000000000000000000000000111111111111111111111111111111000000000000000000000000000000')
		);
		$dw = new  DateWindows();


		$eventWindow = $dw->eventToBoolWeek($eventWindow);
		$eventMask = $dw->eventToBoolWeek($eventMask);

		$dw->printCalendarBlock($eventWindow, $eventMask);


		?>
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
	
</main>
<script type="text/javascript" src="script/schedule_event.js"></script>
</body>
</html>