<?php

use ICal\ICal;

if(session_status() !== PHP_SESSION_ACTIVE){ session_start();}
include_once ('CalendarPrinter.php');
include_once ("ICal_Parser/Event.php");
include_once ("ICal_Parser/ICal.php");

if(!isset($toScreen)){
	$toScreen = new CalendarPrinter();
}

	function alert($type, $message){
		$type = $type ? 'good' : 'bad';
		echo "
			<div class=\"alert $type\">
			<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span> 
			<strong>$message</strong>
			</div>
		";
	}

	function printNavigation(){
		$path = "../data/nav.txt";
		$myfile = fopen($path, "r") or die("$path => Unable to open file!");
		echo fread($myfile,filesize($path));
		fclose($myfile);
	};

	function printHead($pageTitle){
		$path = "../data/head.txt";
		$myfile = fopen($path, "r") or die("$path => Unable to open file!");
		echo str_replace('$pageTitle', $pageTitle, fread($myfile,filesize($path)));
		fclose($myfile);
	};
	function printUserButton(){
		echo	"<span class = \"user\">";
		if(isset($_SESSION["user"]) && $_SESSION["user"] instanceof User){
			printProfileAccessButton($_SESSION["user"]->getDisplayName());
		}
		else{ printLoginButton(); }
		echo "</span>";
	}
	function printProfileAccessButton($DisplayName){
		$path = "../data/profile.txt";
		$myfile = fopen($path, "r") or die("$path => Unable to open file!");
		echo str_replace('$DisplayName', $DisplayName, fread($myfile,filesize($path)));
		fclose($myfile);
	};
	function printLoginButton(){
		$path = "../data/login.txt";
		$myfile = fopen($path, "r") or die("$path => Unable to open file!");
		echo fread($myfile,filesize($path));
		fclose($myfile);
	}

	function construct_mask_from_calendars($event, $calendars){
		
		$ical_options = array(
			'defaultSpan'                 => 2,     // Default value
			'defaultTimeZone'             => 'UTC',
			'defaultWeekStart'            => 'SU',  
			'disableCharacterReplacement' => false, // Default value
			'filterDaysAfter'             => null,
			'filterDaysBefore'            => null,
			'skipRecurrence'              => false, // Default value
		);
		$appointments = array();
		foreach($calendars as &$cal){
			//get all apointments within range
			$ical_path = '../calendars/' . $cal;
			$ical = new ICal($ical_path, $ical_options);
			$appointments = array_merge($appointments, $ical->eventsFromRange($event->getStartDate()->format('Y-m-d H:i:s'), $event->getEndDate()->add(new DateInterval('P1D'))->format('Y-m-d H:i:s')));

		}
		unset($cal);


		$days = array();
		foreach($appointments as &$app){
			// turn each appointment into a day
			$start = $app->dtstart;
			$end = $app->dtend;
			$date_pattern = '/^(\d{4})(\d{2})(\d{2})/';
			$date_replace = '$1-$2-$3';
			$date = new DateTime(preg_replace($date_pattern, $date_replace, $start));
			$day = new Day($date,1);

			preg_match('/T(\d{4}).*$/', $start, $start_time);
			preg_match('/T(\d{4}).*$/', $end, $end_time);

			$day->setAvailiblity(false, $start_time[1], $end_time[1]);
			$key = $date->format('Ymd');
			if(array_key_exists($key, $days)){
				$days[$key]->merge($day);
			}else{
				$days[$key] = $day;
			}
		}
		unset($app);
		$mask = new Event('mask');
		$mask->setDays($days);
		// $mask->var_dump();
		return $mask;
	}
	function print_appointment_array($array){
		foreach($array as $a){
			if(is_array($a)){
				print_array($a);
			}else{
				echo $a->dtstart . " to " . $a->dtend; 
				echo "<br/>";
			}
		}
	}


?>
