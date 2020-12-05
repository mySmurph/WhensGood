<!--  https://cis444.cs.csusm.edu/group4/WhensGood/ScheduleEvent.php -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
	<title>Create Event</title> 
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
			Create New Event!!
		</h1>

		<form action="ScheduleEvent.php" onsubmit="return ValidateForm()">

			<div class="grid_container">
				<div>
					<ul>
						<li>
							<label aria-label="Give your event a name for people to know what the event is for.">
								Event Name<br />
								<input class="text_input full" type="text" id="event_name" />
							</label>
						</li>
						<li>
							<label aria-label="Set the date range of when you would like your event to take place.">Event Date Range<br /></label>
							<input id="event_date_range_start" class="text_input half calendar" type="date" aria-label="event_date_range_start" placeholder="mm/dd/yyy"/>
							<input id="event_date_range_end" class="text_input half calendar" type="date" aria-label="event_date_range_end" placeholder="mm/dd/yyy"/>
						</li>
						<li>
							<label aria-label="Let your guest know by what date they need to respond by.">RSVP Deadline<br /></label>
							<input id="rsvp_deadline" class="text_input threeQuarters calendar" type="date" aria-label="rsvp_deadline" placeholder="mm/dd/yyy"/>
						</li>
						<li>
							<label aria-label="Set the minimum amount of time you need for your event to take place.">Event Duration<br /></label>
							<div class="text_input full">
								<input type="number" class="durration_time" id="hr" min="0" max="12" value="0" aria-label="Hours" />HR
								<input type="number" class="durration_time" id="min" min="0" max="59" step="15" value="0" aria-label="Minutes"/>MIN
							</div>
						</li>
						<li>
							<label aria-label="Enter your contact info.">
								Organizer's Email<br />
								<input class="text_input full" type="email" id="organizers_email" />
							</label>
						</li>
						<li>
							<label aria-label="Set a password so you can access the scheduler later">Event Password<br /></label>
							<input class="text_input full" type="password" id="event_password" aria-label="password" />
						</li>
						<li>
							<label aria-label="Upload your own calendar so it can be acounted for just like the participents">Organizer's Calendar<br /></label>

							<label class="custom_file_upload"  for="cal_upload">
								<span class="file_upload_button_text">Browse</span>
							</label>
							<input type="text" class="text_input full" readonly="readonly" id="choose_file" aria-label="Browse" />
							<input id="cal_upload" class="create" type="file" aria-label="Browse" />
						</li>
					</ul>

				</div>

				<div>
					<label> Select Event Windows</label>
					<?php
$dw = new  DateWindows();

// // Create Event print empty calendar
// $eventWindow = $dw->emptyBoolWeek();
// $dw->printCalendarWeek($eventWindow);


// Edit event: print calendar from db
$eventWindow = array(
	array('20201124', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
	array('20201125', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
	array('20201126', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
	array('20201127', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
	array('20201128', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
	array('20201129', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
	array('20201130', '000000000000000000000000000000000000111111111111111111111111111111000000000000000000000000000000')
);
$eventWindow = $dw->nonDistinctweek($eventWindow);
$eventWindow = $dw->eventToBoolWeek($eventWindow);
$dw->printCalendarWeek($eventWindow);


?>

					<p class="note">
						* hold CTRL / CMD key to select multiple event windows on the same day <br />
						* click on the Day title to clear all event windows on that day
					</p>
				</div>
			</div>
			<button class="button span red" id="button">Schedule Event</button>
			<p id="feedback" class="feedback">
		<span>Selections Made:</span> 
		<!-- <text id="select-result" name = "select-result"></text> -->
		<textarea type="text" id="select-result" name = "select-result" class="text_input_full"></textarea>
	</p>
		</form>

	</main>
	
	<script type="text/javascript" src="script/Validation.js"></script>
	<script type="text/javascript" src="script/create_event.js"></script>
</body>
</html>
