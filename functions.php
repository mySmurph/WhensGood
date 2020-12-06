<?php
const DATE_INDEX = 0; 
const TIMES_INDEX = 1;
const SEGMENTS_PER_HOUR = 4;
const HOURS_PER_DAY = 24;
const WEEKDAYS = array('SUN', 'MON', 'TUE', 'WED','THR', 'FRI','SAT');
const DAY_CONST = 72000;


	function printNavigation(){
		$nav = "data/nav.txt";
		$myfile = fopen($nav, "r") or die("Unable to open file!");
		echo fread($myfile,filesize($nav));
		fclose($myfile);
	};

	function connectDB(){
	
		// $host =  'localhost';	//cis444 server
		$host =  'db';	// Local Server
		$userid =  'group4';
		$password = 'IjChbKtynlNZ';
		// $password = 'bad password';
		$schema =  'group4';
		try{
			$db =  mysqli_connect($host, $userid,  $password, $schema);
			return $db;
			// if ($db->connect_error){
			// 	print "<p class = \"dbStatus\">Unable to Connect to MySQL</p>". $db -> connect_error;
			// 	throw new Exception('Failed');
			// }else{
			// 	return $db;
			// }
		}catch(mysqli_sql_exception $e){
			throw $e; 
		}
	};

	function validateCode($code){
		try{
			$conn=connectDB();
			if(!$conn){
				return false;
			}
			$sql = "SELECT count(Distinct EventCode) as EventFound from Events Where EventCode = '$code';";
				$result = $conn->query($sql);
				$conn->close();
	
			return intval(array_values(mysqli_fetch_assoc($result))[0])==1;
		}catch(Exception $e){
			return false;
		}
	};
	function validateOrganizer($code, $password){
		try{
			$conn=connectDB();
			if(!$conn){
				return false;
			}
			$sql = "SELECT count(Distinct EventCode) as EventFound from Events Where EventCode = '".$code."' AND  EventPassword like Binary '".$password."' ;";
				$result = $conn->query($sql);
				$conn->close();
	
			return intval(array_values(mysqli_fetch_assoc($result))[0])==1;
		}catch(Exception $e){
			return false;
		}
	};

	// pass event code :: return array ( array(date, 0010))
	function getEventWindow($code){
		try{
			$conn=connectDB();
			if(!$conn){
				return false;
			}
			$sql = "SELECT EventDate Date, TimeArray Time 
			from Days d Inner Join Users u using(UserID) 
			WHERE d.EventCode = '$code' AND u.UserType = 'E' 
			ORDER BY Date ASC ;";

			$result = $conn->query($sql);
			$conn->close();
			$numresults = mysqli_num_rows($result);
			if($numresults<1){
				return false;
			}
			$ev = array();
			for($i = 0; $i < $numresults; $i++){
				array_push($ev, array_values(mysqli_fetch_assoc($result)));
			}

			return $ev;
		}catch(Exception $e){
			return false;
		}
	}
	// pass event code :: return array ( array(date, 1101))
	function getEventMask($code){
		try{
			$conn=connectDB();
			if(!$conn){
				return false;
			}
			$sql = 	"SELECT 
						EventDate Date, TimeArray Time
					FROM Days
					Where
							Days.EventCode = '$code'
						AND Days.TimeArray IS NOT NULL
					;";

			$result = $conn->query($sql);
			$conn->close();
			$numresults = mysqli_num_rows($result);
			if($numresults<1){
				return false;
			}
			//get participants array and transfrom to YYYYMMDD : [1][1][0][1]
			$participantCalendars = array();
			for($i = 0; $i < $numresults; $i++){
				array_push($participantCalendars, array_values(mysqli_fetch_assoc($result)));
			}
			foreach($participantCalendars as &$day){
				//convert time string  to bool array
				$intAr = str_split($day[TIMES_INDEX]);
				foreach($intAr as &$seg){
					$seg = intval($seg);
				}
				$day[TIMES_INDEX] = $intAr;
				$dayofweek = date('w',$day[DATE_INDEX]);
			};

			// make white mask YYYYMMDD : [1][1][1][1]
			$range = getDateRange($code);
			$start = strtotime(preg_replace('/d{4}d{2}d{2}/','-',$range[0]));
			$end = strtotime(preg_replace('/d{4}d{2}d{2}/','-',$range[1]));
			$maskDays = array();
			while($start<=$end){
				array_push($maskDays, array(date("Ymd",$start), getWhite()));
				$start = $start + DAY_CONST;
			}

			//merge participants with mask
			foreach($participantCalendars as &$day){
				foreach($maskDays as &$mask){
					if($day[DATE_INDEX] == $mask[DATE_INDEX]){
						for($i = 0; $i < SEGMENTS_PER_HOUR*HOURS_PER_DAY; $i++){
							$mask[TIMES_INDEX][$i] *= $day[TIMES_INDEX][$i];
						}
					}
				}
				
			}
			foreach($maskDays as &$m){
				$m[TIMES_INDEX] = implode("", $m[TIMES_INDEX]);
			}

			return $maskDays;
		}catch(Exception $e){
			return false;
		}
	}
	function getDateRange($code){
		$ev = getEventWindow($code);
		return array($ev[0][0], $ev[count($ev)-1][0]);
	}
	function getWhite(){
		$white = array();
		for($i; $i < SEGMENTS_PER_HOUR*HOURS_PER_DAY; $i++){
			array_push($white, 1);
		}
		return $white;
	}
		
//functions

class DateWindows{

	function emptyBoolWeek(){
		$firstDay = strtotime("Sunday");
		$emptyWeek = array();
		for($i = 0; $i < 7; $i++){
			array_push($emptyWeek, array( strtotime("+".$i." day", $firstDay), $blackMask));
		}
		return $emptyWeek;
	}
	//------------------------------------------------------
	//------------------------------------------------------
	//2 dim array YYYMMD:00001100 to Date:Bool(Time)
	function eventToBoolWeek($eventWindow){
		$blackMask = '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
		//convete YYYYMMDD to date()
		foreach($eventWindow as &$day){
			$day[DATE_INDEX] = strtotime(preg_replace('/d{4}d{2}d{2}/','-',$day[DATE_INDEX]));
			
		};

		// get number of days before the first day to get to the beguining of the week
		$before = date('w', $eventWindow[0][DATE_INDEX]);
		$firstDay = $eventWindow[0][DATE_INDEX];
		// get number of days after the last till the end of the week
		$after = count(WEEKDAYS)-1 - date('w',$eventWindow[count($eventWindow)-1][DATE_INDEX]);
		$lastDay = $eventWindow[count($eventWindow)-1][DATE_INDEX];

		// insert blackMask days at the beguining of the event
		for($d = 1; $d <= $before; $d++){
			array_unshift($eventWindow, array($firstDay-($d * DAY_CONST), $blackMask));
		};
		// insert blackMask days at the end of the event
		for($d = 1; $d <= $after; $d++){
			array_push($eventWindow, array($lastDay + ((1+$d) * DAY_CONST), $blackMask));
			// array_push($eventWindow, array(strtotime($lastDay.' +'.$d.' days'), $blackMask));
		};

		// convert time to sys time
		foreach($eventWindow as &$day){
			
			//convert time string  to bool array
			$boolAr = str_split($day[TIMES_INDEX]);
			foreach($boolAr as &$seg){
				$seg = (bool)$seg;
			}
			$day[TIMES_INDEX] = $boolAr;

			$dayofweek = date('w',$day[DATE_INDEX]);

		};
		return $eventWindow;
	}

	//------------------------------------------------------
	//------------------------------------------------------
	function printCalendarMaskedBlock($eventWindow, $eventMask){
		$block = DateWindows::getBlock($eventWindow);
		DateWindows::echoHTMLCalendar($eventWindow, $eventMask, $block[0], $block[1], TRUE);
	}
	//------------------------------------------------------

	function printCalendarBlock($eventWindow){
		$block = DateWindows::getBlock($eventWindow);
		DateWindows::echoHTMLCalendar($eventWindow, NULL, $block[0], $block[1], TRUE);
	}
	//------------------------------------------------------
	function printCalendarWeek($eventWindow){
		$block = array(0, SEGMENTS_PER_HOUR*HOURS_PER_DAY);
		$whiteMask = array();
		for($i = 0; $i < $block[1];$i++){
			array_push($whiteMask, true);
		}

		$eventMask = array();
		$firstDay = $eventWindow[0][DATE_INDEX];
		for($i = 0; $i <7;$i++){
			array_push($eventMask, array($firstDay+($d*DAY_CONST), $whiteMask));
		};
		DateWindows::echoHTMLCalendar($eventWindow, $eventMask, $block[0], $block[1], FALSE);
	}

	//------------------------------------------------------
	//------------------------------------------------------			
	function nonDistinctweek($eventWindow){
		$week = array();
		for($i = 0; $i <7;$i++){
			array_push($week, array(FALSE, $blackMask));
		}
		foreach($eventWindow as &$day){
			$iday = date('w',strtotime(preg_replace('/d{4}d{2}d{2}/','-',$day[DATE_INDEX])));
			$week[$iday] = $day;
		}
		for($i = 0; $i <7;$i++){
			if($week[$i][DATE_INDEX] == false){
				$week[$i][DATE_INDEX] = $week[$i-1][DATE_INDEX]+1;
			}
		}

		return $week;
	}
	//------------------------------------------------------
	//------------------------------------------------------

	function getBlock($eventWindow){
		// find the earliest and latest times to start printing
		$earlyest = count($eventWindow[DATE_INDEX][TIMES_INDEX])-1;
		$latest = 0;
		
		foreach($eventWindow as &$day){

			$i = -1;
			$startFound = false;
			while(!$startFound){
				$startFound = ++$i > $earlyest? true:$day[TIMES_INDEX][$i];
				// echo var_dump($startFound);
			}
			$earlyest = $i-1;// < $earlyest? $i:$earlyest;

			$i = count($eventWindow[DATE_INDEX][TIMES_INDEX]);
			$endFound = false;
			while(!$endFound){
				$endFound = --$i < $latest? true:$day[TIMES_INDEX][$i];
				// echo var_dump($startFound);
			}
			$latest = $i+1;
		}

		// add buffers to time
		$earlyest -= (($earlyest-1)%SEGMENTS_PER_HOUR) +1; 
		$latest += 5-(($latest+1)%SEGMENTS_PER_HOUR);

		// echo $earlyest.$latest;
		return array($earlyest, $latest);

	}

	//------------------------------------------------------
	//------------------------------------------------------

	function echoHTMLCalendar($eventWindow, $eventMask, $earlyest, $latest, $includeDate){


		$class = $includeDate? 'date' :'day';

		//Stat building the  the table
		echo ' <div id = "hour_table_'.$week.'" class="hour_table white">';
		for($iday = 0; $iday < count($eventWindow); $iday++){
			$week = str_pad(intdiv($iday, count(WEEKDAYS)), 2, '0', STR_PAD_LEFT);
			// print time column
			if ($iday % count(WEEKDAYS) == 0){
				echo '<ol class="times"><li class = "'.$class.'"></li>';
				for($time = $earlyest; $time < $latest; ++$time){
					//math
					$hour  = 1+((intdiv($time, SEGMENTS_PER_HOUR)-1) %12);
					//format
					$hour = $hour.':00'.($time<12*SEGMENTS_PER_HOUR?' AM':' PM');
					if(($time% SEGMENTS_PER_HOUR)==0){
						echo '<li class="time">'.$hour.'</li>';
					}
				}
				echo '</ol>';
			}

			$dayOfTheWeek = WEEKDAYS[date('w',$eventWindow[$iday][DATE_INDEX])];
			$date = $includeDate? date("n/j/Y",$eventWindow[$iday][DATE_INDEX]) :'';
			$dateYMD = $includeDate? date("Ymd",$eventWindow[$iday][DATE_INDEX]) :'00000000';

			echo '<ol class = "selectable_list" id="selectable-'.$dayOfTheWeek.'-'.$dateYMD.'">';
			echo '<li class = "'.$class.'">'.$dayOfTheWeek.'<span>'.$date.'</span></li>';
			//print time chunks
			for($time = $earlyest; $time < $latest; ++$time){
				$booEV = $eventWindow[$iday][TIMES_INDEX][$time];
				$booEVA = is_null($eventMask)? true : $eventMask[$iday][TIMES_INDEX][$time];

				$selectClass = $booEV? ($includeDate? ( $booEVA?'':'un').'availible window':'ui-selected'):'';
				
				//math
				$hourM = intdiv($time, SEGMENTS_PER_HOUR);
				$min = 15*($time% SEGMENTS_PER_HOUR);

				//format
				$milHour = str_pad($hourM, 2, '0', STR_PAD_LEFT) .	$min = str_pad($min, 2, '0', STR_PAD_LEFT);

				echo '<li class="segment ui-widget-content '.$selectClass.'" id="'.$dayOfTheWeek.'-'.$time.'-'.$dateYMD.'-'.$milHour.'">'.$dayOfTheWeek.'-'.$milHour.'</li>';
			}				
			echo '</ol>';
		}
		echo '</div>';
	}
	//------------------------------------------------------
	//------------------------------------------------------
	
}
				
?>
