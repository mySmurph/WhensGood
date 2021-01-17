<?php
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/DB_Controller.php");
	include ("../PHP_Functions/functions.php");

	$db = new DB_Controller();
	if(!isset($mask)){
		$mask = new Event('mask');
	}
	if(isset($_POST['gotoThisEvent']) && isset($_SESSION['user'])){
		$code = $_POST['gotoThisEvent'];
		$thisEventObject = $_SESSION['thisEventObject'] = $_SESSION['user']->getEvent($code);
		$thisEventObject->addParticipants(true, $db->getParticipant($code, true));
		$thisEventObject->addParticipants(false, $db->getParticipant($code, false));
		// $mask = construct_mask_from_calendars($db->getCalendarsFiles($code));
	}
	if(!isset($_SESSION['thisEventObject'])){
		$thisEventObject = new Event(null);
	}else{
		$thisEventObject = $_SESSION['thisEventObject'];
	}
?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('Schedule Event');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1> 
			<span id = 'h1'>
			Schedule Event <span class="h1EventCode"> 
			<!-- /* ------------------- print event details ------------------- */ -->
			<?php
				echo	toString($thisEventObject->getCode()) . "&nbsp;&mdash;&nbsp;" . toString($thisEventObject->getTitle()); 			?>
			<!-- /* ------------------- ------------------- ------------------- */ -->
			</span> 
			<a href="CreateEvent.php" class = "note"> [Edit Event]</a>
			</span> 
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
		</h1>
		<form  class = "scrollable" id = "Schedule_form">
			<div class="grid_container_flexable">
				<div>
					<!-- ----------------- php prints calendar object ----------------- -->
					<?php
						$list_of_ical_for_mask = $db->getCalendarsFiles($thisEventObject->getCode());
						$mask = construct_mask_from_calendars($thisEventObject, $list_of_ical_for_mask);
						$toScreen->printCalendar($thisEventObject, $mask, 2);
					?>
					<!-- ----------------- -------------------------- ----------------- -->
				</div>

				<div class = "full">
					<div class = "RSVP_list">
						<h2>Accept</h2>
						<ul id = "accept" class = "RSVP_list_ul">

							<!-- /* ------------------- print list of names : accepted ------------------- */ -->
							<?php
								$participants = $thisEventObject->getParticipants(TRUE);
								if($participants){
									foreach($participants as $name){ echo '<li>'.$name.'</li>'; }
								}
							?>
							<!-- /* ------------------- ------------------------------- ------------------- */ -->
							
						</ul>
					</div>
					<div class = "RSVP_list">
						<h2>Decline</h2>
						<ul id = "decline" class = "RSVP_list_ul">
							<!-- /* ------------------- print list of names : decline ------------------- */ -->
							<?php
								$participants = $thisEventObject->getParticipants(false);
								if($participants){
									foreach($participants as $name){ echo '<li>'.$name.'</li>'; }
								}
							?>
							<!-- /* ------------------- ----------------------------- ------------------- */ -->
						</ul>
					</div>
				</div>

			</div>

			<input type="button" class="button span red" id = "button" value = "Schedule Event" />

		</form>
	</main>

	<script type="text/javascript" src="../script/schedule_event.js"></script>

</body>
</html>