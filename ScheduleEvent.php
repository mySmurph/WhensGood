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
	const DATE_INDEX = 0; 
	const TIMES_INDEX = 1;
	const SEGMENTS = 4;
	const WEEKDAYS = array('SUN', 'MON', 'TUE', 'WED','THR', 'FRI','SAT');
	
		$eventWindow = array(
			array('20201124', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
			array('20201125', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
			array('20201126', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
			array('20201127', '000000000000000000000000000000000000000000000000111111111111111111111111111100000000000000000000'), 
			array('20201128', '000000000000000000000000000000000111111111111111111111111111111111111111111111111111000000000000'),
			array('20201129', '000000000000000000000000000000000000111111111111111111111111111111110000000000000000000000000000'),
			array('20201130', '000000000000000000000000000000000000111111111111111111111111111111000000000000000000000000000000')
		);
		$eventWindowAvailible = array(
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


		$eventWindowAvailible = $dw->eventToBoolWeek($eventWindowAvailible);

		$dw->printCalendar($eventWindow, $eventWindowAvailible);


		//functions
		class DateWindows{
			//2 dim array YYYMMD:00001100 to Date:Bool(Time)
			function eventToBoolWeek($eventWindow){
			$empty = '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000';
				// get number of days before the first day to get to the beguining of the week
				$before = date('w', strtotime(preg_replace('/d{4}d{2}d{2}/','-',$eventWindow[0][DATE_INDEX])));
				$firstDay = (int)($eventWindow[0][DATE_INDEX]);
				// get number of days after the last till the end of the week
				$after = count(WEEKDAYS)-1 - date('w', strtotime(preg_replace('/d{4}d{2}d{2}/','-',$eventWindow[count($eventWindow)-1][DATE_INDEX])));
				$lastDay = (int)($eventWindow[count($eventWindow)-1][DATE_INDEX]);
	
				// insert empty days at the beguining of the event
				for($d = 1; $d <= $before; $d++){
					array_unshift($eventWindow, array($firstDay-$d, $empty));
				};
				// insert empty days at the end of the event
				for($d = 1; $d <= $after; $d++){
					array_push($eventWindow, array($lastDay+$d, $empty));
				};
	
				// convert time to sys time
				foreach($eventWindow as &$day){
					$day[DATE_INDEX] = strtotime(preg_replace('/d{4}d{2}d{2}/','-',$day[DATE_INDEX]));
					
					//convert time string  to bool array
					$boolAr = str_split($day[TIMES_INDEX]);
					foreach($boolAr as &$seg){
						$seg = (bool)$seg;
					}
					$day[TIMES_INDEX] = $boolAr;
	
					$dayofweek = date('w',$day[DATE_INDEX]);
					echo $WEEKDAYS[$dayofweek].'&nbsp;';
				};
				return $eventWindow;
			}
			function printCalendar($eventWindow, $eventWindowAvailible){
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
				$earlyest -= (($earlyest-1)%SEGMENTS) +1; 
				$latest += 5-(($latest+1)%SEGMENTS);


				
				echo ' <div id = "hour_table_'.$week.'" class="hour_table white">';
				for($iday = 0; $iday < count($eventWindow); $iday++){
					$week = str_pad(intdiv($iday, count(WEEKDAYS)), 2, '0', STR_PAD_LEFT);
					// print time column
					if ($iday % count(WEEKDAYS) == 0){
						echo '<ol class="times"><li class = "date"></li>';
						for($time = $earlyest; $time < $latest; ++$time){
							//math
							$hour  = 1+((intdiv($time, SEGMENTS)-1) %12);
							//format
							$hour = $hour.':00'.($hourM<12?' AM':' PM');
							if(($time% SEGMENTS)==0){
								echo '<li class="time">'.$hour.'</li>';
							}
						}
						echo '</ol>';
					}

					$dayOfTheWeek = WEEKDAYS[date('w',$eventWindow[$iday][DATE_INDEX])];
					$date = date(" n/j/Y",$eventWindow[$iday][DATE_INDEX]);

					echo '<ol class = "selectable_list" id="selectable-'.$dayOfTheWeek.'-'.date("Ymd",$eventWindow[$iday][DATE_INDEX]) .'">';
					echo '<li class = "date">'.$dayOfTheWeek.'<span>'.$date.'</span></li>';
					//print time chunks
					for($time = $earlyest; $time < $latest; ++$time){
						$booEV = $eventWindow[$iday][TIMES_INDEX][$time];
						$booEVA = $eventWindowAvailible[$iday][TIMES_INDEX][$time];
						//math
						$hourM = intdiv($time, SEGMENTS);
						$min = 15*($time% SEGMENTS);

						//format
						$milHour = str_pad($hourM, 2, '0', STR_PAD_LEFT) .	$min = str_pad($min, 2, '0', STR_PAD_LEFT);

						echo '<li class="segment ui-widget-content '.($booEV? ( $booEVA?'':'un').'availible window':'').'" id="'.$dayOfTheWeek.'-'.date("Ymd",$eventWindow[$iday][DATE_INDEX]).'-'.$milHour.'">'.$dayOfTheWeek.'-$milHour</li>';
					}				
					echo '</ol>';
				}
				echo '</div>';
			}
			
		}

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