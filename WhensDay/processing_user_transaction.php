<?php

	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/DB_Controller.php");
	include ("../PHP_Functions/functions.php");

	$db = new DB_Controller();
	$user_loggedin = ( isset($_SESSION['user']) ) && ( $_SESSION['user'] instanceof User ) && ( $db->usernameExist($_SESSION['user']->getUsername()) );

	$try_create_event = true;
	if( !isset($_SESSION['thisEventObject'])
		||	!($_SESSION['thisEventObject'] instanceof Event) 
		||	!isset($_POST['event_title'])
		||	!isset($_POST['event_date_range_start'])
		||	!isset($_POST['event_date_range_end'])
		||	!isset($_POST['rsvp_deadline'])
		||	!isset($_POST['hr'])
		||	!isset($_POST['min'])
		||	!isset($_POST['window_selection'])
	){
		$try_create_event = false;
	}
?>

<!DOCTYPE html>
	<!-- ----------------- php prints htmlheader ----------------- -->
		<?php	printHead('Processing...');	?>
	<!-- ----------------- --------------------- ----------------- -->
<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
		<div> 
		<!-- empty div, nay is usualy here but this is a wating page -->
		...
 		</div>
	<!-- ----------------- --------------------- ----------------- -->
	<main>
	<h1>
		Please wait to be redirected...
	</h1>
	<?php
	// echo "try_create_event = $try_create_event<br/>";
	if($try_create_event){
		// var_dump($_POST);
		// $username = 'SMurphette_3396';
		// update the existing event object
		$title = htmlspecialchars($_POST['event_title']);
		$date_deadline =  new DateTime($_POST['rsvp_deadline']);
		$seg = (intval($_POST['hr']) * 4) + intdiv(intval($_POST['min']), 15);

		$date_start = new DateTime($_POST['event_date_range_start']);
		$date_end =  new DateTime($_POST['event_date_range_end']);
		$window_selections = explode('#', $_POST['window_selection']); //#0:022#0:023#0:024#0:025#0:026
		// day object array
		$days_made_from_selection = selectionToDay($date_start, $date_end, $window_selections);
		
		$_SESSION['thisEventObject']->setTitle($title);
		$_SESSION['thisEventObject']->setDuration($seg);
		$_SESSION['thisEventObject']->setDeadline($date_deadline);
		$_SESSION['thisEventObject']->setDays($days_made_from_selection);

		// $_SESSION['thisEventObject']->var_dump();
	}
	if($user_loggedin){
		if( !$db->writeEvent($_SESSION['user']->getUsername(), $_SESSION['thisEventObject'])){
			$try_create_event = false;
			alert(false, "could not insert event");
		}
	}else{
		$try_create_event = false;
	}
	?>
	<div id = "notice" class = "lookup_box"></div>
	<input class = "POST_info" disabled type="checkbox" name="transaction_complete" name = "transaction_complete" id = "transaction_complete" <?php echo $try_create_event? 'checked': '' ; ?> />
	<input class = "POST_info" disabled type="checkbox" name="user_loggedin" name = "user_loggedin" id = "user_loggedin" <?php echo $user_loggedin? 'checked': '' ; ?> />
	</main>
	<script> 
	var notice = document.getElementById('notice');
	var message = 'Your event has sucesfully been created.'
	window.addEventListener("load", function() {
		var transaction_complete = document.getElementById('transaction_complete').checked;
		var user_loggedin = document.getElementById('user_loggedin').checked;
		var destination =  transaction_complete? 'ScheduleEvent.php':(user_loggedin?'CreateEvent.php':'User_Login.php');

		if(transaction_complete){
			// setTimeout(function(){window.location.href = destination;}, 10000);
		}else{
			message = user_loggedin? "There was an error creating your event." : "Please Login to Create Event";
		}
		notice.innerHTML = "<b>" + message + "</b><br/><br/>If this page does not automatically redirect please click the 'Continue' button <a href=\"../WhensDay/" + destination + "\"><button class = \"red button span full\">Continue</button></a>";
	});
	</script>
</body>
</html>