<?php
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/DB_Controller.php");
	include ("../PHP_Functions/process_user_transaction_RSVP.php");
	include ("../PHP_Functions/functions.php");
	
	// test object
	// include ("../data/object_myEvent.php");
	$db = new DB_Controller();
	$event_not_found_alert = false;
	$event_found = false;
	
	// var_dump($_POST);
	//Stage 2
	if(isset($_POST['lookup_event']) && is_string($_POST['lookup_event'])) {
		$code = $_POST['lookup_event'];
		if($db->eventExist($code)){
			$_SESSION["thisEventObject"] = $thisEventObject = $db->getEvent($code);
			$event_found = true;
		}
		else{
			$event_not_found_alert = true;
		}
	}

	// Stage 3
	$process_rsvp = false;
	if(isset($_POST["process_rsvp"]) && boolval($_POST["process_rsvp"])){
		$thisEventObject = $_SESSION["thisEventObject"];
		$code = $thisEventObject->getCode();
		$process_rsvp = true;
		$user = null;
		$calendar_file = null;
		$rsvp = false;

	
		if(isset($_SESSION['user']) && $_SESSION["user"] instanceof User){
			//use current user
			$user = $_SESSION['user'];
		}else{
			//from the email submitted se if we an find a user id
			$user = new User(null, $_POST['participant_name'], $_POST['email']);
			$db->insertUser($user, null);
		}

		if(isset($_POST["rsvp_reponce"]) && $_POST["rsvp_reponce"] == 'true'){
			$rsvp = true;
			$calendar_file = uploadCalendarFile($user->getUsername());
		}
		
		$rsvp_processed = $db->insertParticpant($code, $user->getUsername(), $rsvp, $calendar_file);
	}

	if(!isset($thisEventObject)){
		$thisEventObject = new Event();
	}
?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('RSVP to Event');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1>
			<span id = 'h1'>
				RSVP to Event
				
					<!-- /* ------------------- print event details ------------------- */ -->
					<?php
						if($event_found){
							echo	"<span class=\"h1EventCode\">". toString($thisEventObject->getCode()) . "&nbsp;&mdash;&nbsp;" . toString($thisEventObject->getTitle()) . "</span> "; 
						}
						
					?>
					<!-- /* ------------------- ------------------- ------------------- */ -->
				
			</span> 
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
		</h1>
		<span id = "alerts_go_here">
		</span>

		<form class = "lookup_box" id = "form_lookup_event" method="POST" enctype="multipart/form-data">
			<label>Event Code</label>
			<input type="text" class = "full" placeholder="Event Code" value = "" id = "lookup_event" name = "lookup_event" />
			<input type = "button" id = "btn_lookup" class = "red span" value = "RSVP to Event"/>
		</form>

		<form class = "scrollable"  id = "form_RSVP_to_event" method="POST" enctype="multipart/form-data">
			<div class="grid_container_flexable">
				<div>
					<div class="grid_container_setWidth">
							<div class="RSVP_details">
								<h2 aria-label="Deadline to RSVP">RSVP Deadline</h2>
								<div class = "event_date">
								<!-- ----------------- php prints deadline ----------------- -->
									<?php 	echo toString($thisEventObject->getDeadline());	?>
								<!-- ----------------- --------------------- ----------------- -->
								</div>
							</div>
							<div class="RSVP_details">
								<h2>Event Duration</h2>
								<div>
									<!-- ----------------- php prints durration ----------------- -->
									<?php echo $thisEventObject->getTimeDuration()['hour']; ?>
									<span class = "xm"> HR </span>
									<?php echo $thisEventObject->getTimeDuration()['min']; ?>
									<span class = "xm"> MIN </span>
									<!-- ----------------- -------------------- ----------------- -->
								</div>
							</div>
					</div>
					<!-- ----------------- php prints calendar object ----------------- -->
					<?php
						$toScreen->printCalendar($thisEventObject, null, 1);
					?>
					<!-- ----------------- -------------------------- ----------------- -->
				</div>

				<div>
					<ul>
						<li>
							<label>Participant's Name</label>
							<input type="text" class="input_type_text full" name="participant_name" id="participant_name"
								<?php
									if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User){
										echo "value = '" . $_SESSION['user']->getDisplayName() . "' readonly";
									}
								?>
							/>
						</li>
						<li>
							<label>Participant's Email</label>
							<input class="input_type_text full" type="email" name="email" id="email"
								<?php
									if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User){
										echo "value = '" . $_SESSION['user']->getEmail() . "' readonly";
									}
								?>
							/>
						</li>
						<li>
							<label>Accept Event Participation</label>
							<div class="switchbox">
										<div class = "label">Decline</div>
										<input type="checkbox" name="rsvp_reponce" id="rsvp_reponce" data-check-switch aria-label="rsvp_reponce" value = "true" />
										<div class = "label">Accept</div>
							</div>
							
						</li>
						<li>
							<label aria-label="Upload your calendar">Participant's Calendar</label>
							<ul class = "upload_bar">
								<li>
									<input type="text" class="input_type_text butt_left" placeholder = "file.ics" readonly="readonly" id="choose_file" name = "choose_file" aria-label="Browse" /></li><li><input id="cal_upload" name = "cal_upload" type="file" aria-label="Browse" placeholder="cal_upload" accept=".ics"/>
									<label for = "cal_upload" class = "butt_right">Browse...</label>
								</li>
							</ul>
						</li>
						<li>
							<input type = "button" class="red span" id = "btn_RSVP" value = "RSVP to Event" />
						</li>
					</ul>
				</div>
			</div>
					<input type="checkbox" readonly class = "POST_info" name = "process_rsvp" id = "process_rsvp" />
        </form>
  </main>
	
<script type="text/javascript" src="../script/ValidationTests.js"></script>
<script type = "text/javascript">
//Lookup JS
var alerts_go_here = document.getElementById("alerts_go_here");

var form_RSVP_to_event = document.getElementById("form_RSVP_to_event");
var form_lookup_event = document.getElementById("form_lookup_event");
var event = document.getElementById("lookup_event");

document.getElementById("btn_lookup").addEventListener('click', function(){ valid_EventCode()});
function valid_EventCode(){

	if(validCode(event)){
		form_lookup_event.submit();
	}else{
		alerts_go_here.innerHTML = alert(false, "Invalid Event Code Entered.");
	}
}

//participant responce
var participant_name = document.getElementById("participant_name");
var participant_email = document.getElementById("email");
var participant_rsvp = document.getElementById("rsvp_reponce").checked;
var file = document.getElementById("choose_file");

var btn_browse = document.getElementById("cal_upload");
btn_browse.addEventListener('change', function(){changeFileName()});
function changeFileName(){
	console.log(btn_browse.value);
	file.value = (btn_browse.value).replace("C:\\fakepath\\", "");
}

document.getElementById("btn_RSVP").addEventListener('click', function(){valid_RSVP()});
function valid_RSVP(){
	validCalendar(file);
	if(validString(participant_name) && validEmail(participant_email) && ( !participant_rsvp || (participant_rsvp && validCalendar(file))) ){
		document.getElementById("process_rsvp").checked = true;
		form_RSVP_to_event.submit();
	}
}


</script>
<?php
echo "<script type = \"text/javascript\">";
	if($event_not_found_alert){
		echo "
		alerts_go_here.innerHTML = alert(false, \"Event Not Found\");
		";
	}
	if($event_found){
		echo "
		form_lookup_event.style.display = 'none';
		form_RSVP_to_event.style.display = 'block';
		";
	}else{
		echo "
		form_lookup_event.style.display = 'block';
		form_RSVP_to_event.style.display = 'none';
		";
		if($process_rsvp){
			if($rsvp_processed){
				echo " alerts_go_here.innerHTML = alert(true, \"Thank you for submitting your RSVP responce!\"); ";
			}else{
				echo " alerts_go_here.innerHTML = alert(false, \"There was an error and your responce could not be recoreded.\"); ";
			}
			unset($_SESSION['thisEventObject']);
		}
	}
	echo "</script>";
?>
</body>
</html>