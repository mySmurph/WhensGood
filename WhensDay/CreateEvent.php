<?php
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/functions.php");

	$is_existing_event = isset($_SESSION['thisEventObject']) && $_SESSION['thisEventObject'] instanceof Event;

	$_SESSION['thisEventObject'] =( $thisEventObject = ($is_existing_event) ? $_SESSION['thisEventObject'] : new Event());


?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('Create|Edit Event');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1>
			<span id = 'h1'>
				<!-- /* ------------------- print message ------------------- */ -->
				<?php echo	$is_existing_event ? "Edit Event" : "Create New Event"; ?>
				<!-- /* ------------------- ------------------- ------------------- */ -->
					<span class="h1EventCode">
					<!-- /* ------------------- print event details ------------------- */ -->
					<?php echo	$thisEventObject->getCode(); ?>
					<!-- /* ------------------- ------------------- ------------------- */ -->
					</span>
			</span>
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
		</h1>

		<form class = "scrollable" name = "form_CreateEvent" id = "form_CreateEvent" enctype="multipart/form-data">

			<div class="grid_container_flexable">
				<div>
					<ul>
						<li>
							<label aria-label="Give your event a title for people to know what the event is for.">
								Event Title</label>
								<input class = "input_type_text full" type = "text" id = "event_title" name = "event_title" 
								value = "<?php echo toString($thisEventObject->getTitle()); ?>" placeholder="Event Title"/>
						</li>
						<li>
							<label aria-label = "Set the date range of when you would like your event to take place.">Event Date Range</label>
							<div class="input_type_text full" >
								<input id = "event_date_range_start" name = "event_date_range_start"  type="date" aria-label="event_date_range_start" 
								placeholder="mm / dd / yyyy"
								value = "<?php echo $is_existing_event? toString($thisEventObject->getStartDate()):''; ?>" />&nbsp;&mdash;&nbsp; 
								<input id = "event_date_range_end" name = "event_date_range_end"  type = "date" aria-label="event_date_range_end"  
								placeholder="mm / dd / yyyy"
								value = "<?php echo $is_existing_event? toString($thisEventObject->getEndDate()):''; ?>" />
							</div>
						</li>
						<li>
							<label aria-label = "Let your guest know by what date they need to respond by.">RSVP Deadline</label>
							<div class="input_type_text full" >
								<input id = "rsvp_deadline" name = "rsvp_deadline"  type = "date" aria-label="rsvp_deadline" 
								placeholder="mm / dd / yyyy"
								value = "<?php echo toString($thisEventObject->getDeadline()); ?>" />
							</div>
						</li>
						<li>
							<label aria-label = "Set the minimum amount of time you need for your event to take place.">Event Duration</label>
							<div class = "input_type_text full ">
								<input type = "number" class=" " id = "hr" name = "hr" min="0" max="12" aria-label="Hours" 
								value = "<?php echo $thisEventObject->getTimeDuration()['hour']; ?>" />
								<span class = "xm"> HR </span>
								<input type = "number" class=" " id = "min" name = "min" min="0" max="59" step="15" aria-label="Minutes" 
								value = "<?php echo $thisEventObject->getTimeDuration()['min']; ?>" />
							<span class = "xm"> MIN </span>
							</div>
						</li>
					</ul>

				</div>

				<div>
					<!-- ----------------- php prints calendar object ----------------- -->
					<?php
						$toScreen->printCalendar($thisEventObject, null, 0);
					?>
					<!-- ----------------- -------------------------- ----------------- -->
					<p class="note">
						* hold CTRL / CMD key to select multiple event windows on the same day <br />
						* click on the Day title to clear all event windows on that day
					</p>
				</div>
			</div>
			<input type = "button" class="button span red" id="button" value = "Organize Event" />
				<input class ="POST_info" readonly type = "text" name = "window_selection" id = "window_selection"  readonly />
				<input class ="POST_info" disabled type="checkbox" name="isEdit" name = "isEdit" id = "isEdit" <?php echo $is_new_event? 'checked': '' ; ?> />
		</form>
	</main>
	<script type="text/javascript" src="../script/CreateEvent_Valid.js"></script>
	<script type="text/javascript" src="../script/ValidationTests.js"></script>
	<script type="text/javascript" src="../script/CreateEvent_Select.js"></script>
</body>
</html>
