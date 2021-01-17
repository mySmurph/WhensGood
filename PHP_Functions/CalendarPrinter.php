<?php
class CalendarPrinter{

const WEEKDAYS = ['Sun', 'Mon', 'Tue', 'Wed','Thur', 'Fri','Sat'];
const JS_SELECT_OL = 'selectable_list';
const JS_SELECT_LI = 'segment ui-widget-content';
const JS_AVAILIBLE = 'window';
const JS_SELECTED_LI = 'ui-selected';
const JS_NOTAVAILIBLE = 'unavailible';
const ENDL = "\r\n";

const TYPE_24HR_DAY = 0;
const TYPE_BLOCK = 1;
const TYPE_MASK_BLOCK = 2;
const PRINT_TYPE = [
	self::TYPE_24HR_DAY => 'whole',
	self::TYPE_BLOCK => 'block',
	self::TYPE_MASK_BLOCK => 'masked block'
];

private $isType; // 0 = nondistinct calendar, 1 = RSVP block without mask, 2 = schedule block with mask ... isType > 0 ? Block : Whole Day that wraps
private $event;
private $mask;
private $earliest_hour;
private $latest_hour;
private $class;

public function __construct(){/** this is for use so there is not much to do */}
private function set($event, $mask, $type){
	$this->event = clone $event;
	$this->mask = $mask;
	$this->isType = ($type == self::TYPE_MASK_BLOCK && is_null($mask))? self::TYPE_BLOCK : $type;
	if($this->isType != self::TYPE_24HR_DAY){
		$block = $this->event->getBlock();
		$this->earliest_hour = $block[0];
		$this->latest_hour = $block[1];
	}else{
		$this->earliest_hour = 0;
		$this->latest_hour = NUM_SEGMENTS;
		$this->wrapWeek();
	}
	$this->class = $this->isType == self::TYPE_24HR_DAY ? 'day' : 'include_date';
}
private function unset(){
	unset($this->event);
	unset($this->mask);
	unset($this->earliest_hour);
	unset($this->latest_hour);
	unset($this->type);
	unset($this->class);
}
public function printCalendar($event, $mask = null, $type = 1){
	$this->set($event, $mask, $type);

		$week = 0;
		echo "<div class = \"selectable_calendar_object_container\">";
		echo "<h2>" ;
		if($this->isType != self::TYPE_24HR_DAY){
			echo $this->event->getStartDate()->format('F Y');
		}else{
			echo "Select Event Windows";
		}
		echo "</h2>" ;
		echo "<div id = \"selectable_calendar_object_$week\" class=\"selectable_calendar_object\">".self::ENDL;
		$this->printTimes();
		$this->printPreDate();

		$firstDay = true;
		foreach($this->event->getDays() as $day){
			if($day->getDate()->format('w') == 0 && !$firstDay){
				$week++;
				echo "</div>".self::ENDL."<div id = \"selectable_calendar_object_$week\" class=\"selectable_calendar_object\">".self::ENDL;
				$this->printTimes();
			}
			$this->printDay($day);
			$firstDay = false;
		}
		$this->printPostDate();

		echo "</div></div>".self::ENDL;

	$this->unset();
}
private function printPreDate(){
	$firstDay = clone $this->event->getStartDate();
	$num_days_before = $firstDay->format('w');
	$firstDay->sub(new DateInterval('P'.$num_days_before.'D'));

	for( ;  $num_days_before > 0 ; $num_days_before-- ){
		$this->printFillerDay($firstDay);
		$firstDay->add(new DateInterval('P1D'));
	}
}
private function printPostDate(){
	$lastDay = clone $this->event->getEndDate();
	$num_days_after = 7 - $lastDay->format('w');
	for( $after = 1 ;  $after < $num_days_after; $after++){
		$this->printFillerDay($lastDay->add(new DateInterval('P1D')));
	}
}
private function printFillerDay($date){ 
	$day_of_the_week = $date->format('w');			// 0
	$dayName = self::WEEKDAYS[$day_of_the_week];	// SUN
	$dateID = $date->format('Y-m-d');						// 2020-12-27
	$dateString = $this->isType == self::TYPE_24HR_DAY? '' : '<br/><span class = "date" >'.$date->format('j').'</span>';				// 12/27/2020

	$id = $day_of_the_week.'_'.$dateID;				//0_2020-12-27
	$hour_index = $this->earliest_hour;

	echo "<ol class = \"" . self::JS_SELECT_OL . "\" id = \"$id\" >";								//	<ol  class = "selectable_list" id = "0_2020-12-27">
		echo "<li class = \" ".$this->class."\">$dayName$dateString</li>".self::ENDL;	//	<li class = "date">SUN<span>12/27/2020</span></li>
		while($hour_index < $this->latest_hour){
			$id_hour = $id.'_'.str_pad($hour_index++, 3, '0', STR_PAD_LEFT);
			echo "<li class = \"" . self::JS_SELECT_LI . "\" id = \"$id_hour\" ></li>".self::ENDL;	 //	<li class = "segment ui-widget-content" id = "0_2020-12-27_023" ></li>
		}
	echo "</ol>".self::ENDL;																		//	</ol>
}
private function printTimes(){
	echo "<ol class=\"times\"><li class = \"".$this->class."\"></li>".self::ENDL;
	$hour = $this->earliest_hour;
	while($hour < $this->latest_hour){
		$hr = intdiv($hour, SEGMENTS_PER_HOUR);		// 56 to 14
		$xm = $hr < 12 ? 'am' : 'pm';				// 14 means PM
		$hr = $hr%12;								// 14 to 2
		$hr = $hr==0?12:$hr;						// if (hr == 0) then (hr = 12) 
		$timeString = str_pad($hr++, 2, ' ', STR_PAD_LEFT).' <span class = "xm"> '.$xm . '</span>';	// ' 2 PM'
		echo "<li class=\"time\">$timeString</li>".self::ENDL;
		$hour += SEGMENTS_PER_HOUR;
	}
	echo "</ol>".self::ENDL;
}
private function printDay($day){
	$date = $day->getDate();
	$day_of_the_week = $date->format('w');			// 0
	$dayName = self::WEEKDAYS[$day_of_the_week];	// SUN
	$dateID = $date->format('Y-m-d');						// 2020-12-27
	$dateString = $this->isType == self::TYPE_24HR_DAY? '' : '<br/><span class = "date" >'.$date->format('j').'</span>';					// 12/27/2020

	$id = $day_of_the_week.'_'.$dateID;				//0_2020-12-27
	$hour_index = $this->earliest_hour;

	$mask = ($this->isType == self::TYPE_MASK_BLOCK) ? $this->mask->getDayByDate($date) : null;

	echo "<ol class = \"" . self::JS_SELECT_OL . "\" id = \"$id\" >\r\n";								//	<ol  class = "selectable_list" id = "0_2020-12-27">
		echo "<li class = \"".$this->class."\">$dayName$dateString</li>\r\n";	//	<li class = "date">SUN<span>12/27/2020</span></li>
		while($hour_index < $this->latest_hour){
			$id_hour = $id.'_'.str_pad($hour_index, 3, '0', STR_PAD_LEFT);

			$class = '';
			if($day->getAvailibility($hour_index)){
				$class = $this->isType == self::TYPE_24HR_DAY ? self::JS_SELECTED_LI : self::JS_AVAILIBLE;
				if(!is_null($mask)){
					if(!$mask->getAvailibility($hour_index)){
						$class = self::JS_NOTAVAILIBLE;
					}
				}
			}
			
			echo "<li class = \"".self::JS_SELECT_LI." $class\" id = \"$id_hour\" ></li>\r\n";	 //	<li class = "segment ui-widget-content __un/avail__ window" id = "0_2020-12-27_023" ></li>
			$hour_index++;
		}
	echo "</ol>\r\n";	
}
public function wrapWeek(){
	//make a blank week
	$thisDay = clone $this->event->getStartDate();
	$days_from_sunday =  $thisDay->format('w');
	$thisDay->sub(new DateInterval('P' .$days_from_sunday. 'D'));
	// $this->event->var_dump();
	$week = array();
	for($i = 0; $i < 7; $i++){
		// var_dump($thisDay);
		array_push($week, new Day(clone $thisDay, 0));
		$thisDay->add(new DateInterval('P1D'));
	}

	//put days that exist in the week
	foreach($this->event->getDays() as $d){
		$week[$d->getDate()->format('w')]->setTime($d->getTime());
	}
	$this->event->setDays($week);

}

}
?>