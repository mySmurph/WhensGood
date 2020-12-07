<?php

	if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	//if event found then edit event, else create event
	$editEvent = isset($_SESSION["eventFound"]) && isset($_SESSION["event_code"])? $_SESSION["eventFound"]: false;
?>
<!--  https://cis444.cs.csusm.edu/group4/WhensGood/ScheduleEvent.php -->
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
	if($editEvent){
		$code = $_SESSION["event_code"];
		$eventWindow = getEventWindow($code);
		$title = getTitle($code);
		$deadLine = getDeadline($code);
		$Duration = getDuration($code); //array( 0=>[hour], 1=>[min])
		$range = getDateRange($code);
			$start = date("Y-n-j", strtotime(preg_replace('/d{4}d{2}d{2}/','-',$range[0])));
			$end =   date("Y-n-j", strtotime(preg_replace('/d{4}d{2}d{2}/','-',$range[1])));
		$email = getEventEmail($code);
		$h1 = "Edit Event";
		unset($_SESSION["eventFound"]);
		unset($_SESSION["event_code"]);
	}else{
		$code = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
		$eventWindow = array(
			array('20200105', '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000')
		);
		$h1 = "Create New Event!!";
		$Duration = array(0,0);
	}
	?>

	<main id="main">
		<h1>
		<?php echo $h1?> <span class="h1EventCode"> <?php echo $code?> </span>
		</h1>

		<form action="ScheduleEvent.php" onsubmit="return ValidateForm()">

			<div class="grid_container">
				<div>
					<ul>
						<li>
							<label aria-label="Give your event a title for people to know what the event is for.">
								Event Title<br />
								<input class="text_input full" type="text" id="event_name" value = "<?php echo $title?>" />
							</label>
						</li>
						<li>
							<label aria-label="Set the date range of when you would like your event to take place.">Event Date Range<br /></label>
							<input id="event_date_range_start" class="text_input half calendar" type="date" aria-label="event_date_range_start" placeholder="mm/dd/yyy" value = "<?php echo $start ?>"/>
							<input id="event_date_range_end" class="text_input half calendar" type="date" aria-label="event_date_range_end" placeholder="mm/dd/yyy" value = "<?php echo $end ?>"/>
						</li>
						<li>
							<label aria-label="Let your guest know by what date they need to respond by.">RSVP Deadline<br /></label>
							<input id="rsvp_deadline" class="text_input threeQuarters calendar" type="date" aria-label="rsvp_deadline" placeholder="mm/dd/yyy" value = "<?php echo $deadLine ?>"/>
						</li>
						<li>
							<label aria-label="Set the minimum amount of time you need for your event to take place.">Event Duration<br /></label>
							<div class="text_input full">
								<input type="number" class="Duration_time" id="hr" min="0" max="12"  value = "<?php echo $Duration[0] ?>"aria-label="Hours" />HR
								<input type="number" class="Duration_time" id="min" min="0" max="59" step="15"  value = "<?php echo $Duration[1] ?>"aria-label="Minutes"/>MIN
							</div>
						</li>
						<li>
							<label aria-label="Enter your contact info.">
								Organizer's Email<br />
								<input class="text_input full" type="email" id="organizers_email"  value = "<?php echo $email ?>"/>
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

$eventWindow = DateWindows::eventToNondistinctWeek($eventWindow);
$eventWindow =  DateWindows::eventToBoolWeek($eventWindow);
DateWindows::printCalendarWeek($eventWindow);
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
