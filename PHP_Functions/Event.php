<?php
	const SEGMENTS_PER_HOUR = 4;
	const MIN_PER_HOUR = 60;
	const HOURS_PER_DAY = 24;
	const NUM_SEGMENTS = 96;

class Event{
	private $code;	//string
	private $title;	//string
	private $duration;	//int
	private $deadline;	//DateTime
	private $days;	//array(Ymd => [<Day>], Ymd => [<Day>], ... )
	private $participants;	//array( true => [<string>, ...], false => [<string>, ...])

	/**
	 * Event Constuctor
	 * 	-	new Event()
	 * 	-	new Event('eventcode')
	 * 	-	new Event(array( 0 => [Y-m-d, '0010']))
	 * 	-	new Event(timeArray, code, title, seg, dead)
	 * @param array|null $timeArray
	 * 	-	defualt null: automatically creates a defualt blank day
	 * 	-	array( 0 => [Y-m-d, '0010']): convert these given array into day objects
	 * @param string|null $code
	 * 	-	defualt null: generate a new unique code
	 * 	-	string
	 * @param string|null $title
	 * 	-	defualt null
	 * 	-	string
	 * @param int|null $seg
	 * 	-	defualt 0
	 * 	-	int
	 * @param string|null $dead
	 * 	-	defualt null
	 * 	-	string 'Y-m-d'
	 *  -	DateTime
	 */
	function __construct($timeArray = null, $code = null, $title = null, $seg = 0, $dead = null){
		//decalre an Event with 1 parma that is the code
		if(is_string($timeArray) && is_null($code)){
			$code = $timeArray;
			$timeArray = null;
		}

		$this->code = is_null($code) ? strtoupper(base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36)) : $code;
		$this->title = $title;
		$this->setDuration($seg);
		$this->setDeadline($dead);
		$this->days = array();
		if(!is_null($timeArray) && is_array($timeArray)){
			$this->newDays($timeArray);
		}
		else{
			$this->setDays(array(new Day(new DateTime('NOW'),0)));
		}
		$this->participants = array(
			true => array(),
			false => array()
		);
	}

	/**
	 * Make New Days
	 * @param array $dArray
	 *	array (
	 * 		[0] => array(
	 * 			[0] => [YYYY-MM-DD]
	 * 			[1] => ["00001100"]
	 * 		)
	 * 		[1] => array(
	 * 			[0] => [YYYY-MM-DD]
	 * 			[1] => ["00001100"]
	 * 		)
	 * 		...
	 * 	)
	 *  result:
	 *	days = array(
	 *			['Ymd'] => Day(date, t/f) 
	 *			['Ymd'] => Day(date, t/f) 
	 *			['Ymd'] => Day(date, t/f) ...
	 *		)
	 */
	public function newDays($dArray){
		foreach($dArray as $d){
			$newDay = new Day($d[0], $d[1]);
			$key = $newDay->getDate()->format('Ymd');
			if(array_key_exists($key, $this->days)){
				//merge days
				$this->days[$key]->merge($newDay); 
			}else{
				//insert day
				$this->days[$key] =  $newDay;
			}
		}
	}

	/**
	 * Set days to premade day array
	 * @param array $premaideDays
	 *  array(
	 *			['Ymd'] => Day(date, t/f) 
	 *			['Ymd'] => Day(date, t/f) 
	 *			['Ymd'] => Day(date, t/f)
	 *		)
	 */
	public function setDays($premadeDays){
		if( is_array($premadeDays) && current($premadeDays) instanceof Day){
			$this->days = $premadeDays;
		}
	}

	/**
	 * Get the array<Day> from this Event
	 * @return array<Day> 
	 */
	public function getDays(){
		return $this->days;
	}

	/**
	 * Get the indexes of whole hour for the earliest time window and the index of the whole hour for the latest time window
	 * @return array(int earliest, int latest)
	 */
	public function getBlock(){
		// find the earliest and latest times to start printing
		$earliest = NUM_SEGMENTS-1;
		$latest = 0;
		
		foreach($this->days as $day){
			$s = $day->getStart();
			$e = $day->getEnd();
			$earliest = $s < $earliest ? $s : $earliest;
			$latest = $e > $latest ? $e : $latest;
		}

		// add buffers to time
		$earliest -= (($earliest-1)%SEGMENTS_PER_HOUR) +1; 
		$latest += 5-(($latest+1)%SEGMENTS_PER_HOUR);

		// echo $earlyest.$latest;
		return array($earliest, $latest);

	}

	/**
	 * Get the date range Start Date
	 * @return DateTime
	 */
	public function getStartDate(){
		$first = array_key_first($this->days);
		return $this->days[$first]->getDate();
	}
	
	/**
	 * Get the date range End Date
	 * @return DateTime
	 */
	public function getEndDate(){
		$last = array_key_last($this->days);
		return $this->days[$last]->getDate();
	}

	/**
	 * Get a specific Day by a given date
	 * @param DateTime $date
	 * 
	 * @return Day
	 * @return null
	 */
	public function getDayByDate($date){
		//find date in event else return null

		$key = $date->format('Ymd');
		return $this->days[$key];

		// foreach($this->days as $d){

		// 	if($d->getDate() == $date){
		// 		return $d;
		// 	}
		// }
		// return null;
	}
	
	/**
	 * Remove a Day from the Event if it exist
	 * @param DateTime $date
	 */
	public function removeDayByDate($date){
		foreach($this->days as $d){
			if($d->getDate() == $date){
				unset($d);
				break;
			}
		}
	}

	/**
	 * prints to bowser window a bisic difinition of the event
	 * (for debugging)
	 */
	public function var_dump(){
		echo " <div style = \"display : block; padding: 10pt; background : #eeeeee;\" >
			Event Code: ".$this->code." <br/>
			Event Title: ".$this->title." <br/>
			Duration: " . (is_null($this->duration) ? 'null' : $this->duration) . " <br/>
			Deadline: ". (is_null($this->deadline) ? 'null' : $this->deadline->format('m/d/Y')) ." <br/>
		";
		
		foreach($this->days as $d){
			$d->var_dump();
		}
		echo "</div>";
	}

	/**
	 * Returns a string of the bisic difinition of the event
	 * (for SQL LOG)
	 */
	public function describe(){
		$description = '
			EventCode => ['.$this->code.']
			EventTitle => ['.$this->title.']
			Duration => [' . (is_null($this->duration) ? 'null' : $this->duration) . ']
			Deadline => ['. (is_null($this->deadline) ? 'null' : $this->deadline->format('Y-m-d')) .']
			Days => [
			';
		foreach($this->days as &$d){
			$description .= ' ' . $d->describe() . '\n';
		}
		unset($d);
		return $description . ']';
	}

	/**
	 * Get the duration of the Evnet as hr:min
	 * @return array(int 'hour', int 'min')
	 */
	public function getTimeDuration(){
		return array(
			'hour' => intdiv($this->duration, SEGMENTS_PER_HOUR),
			'min'  => ($this->duration%SEGMENTS_PER_HOUR)*(MIN_PER_HOUR/SEGMENTS_PER_HOUR)
		);
	}

	/**
	 * Get the duration of the Event in the number of segments
	 * @return int
	 */
	public function getDuration(){
		return $this->duration;
	}

	/**
	 * Set the duration of the event
	 * @param int $seg
	 * number of segments
	 */
	public function setDuration($seg){
		if(is_string($seg)){
			$seg = intval($seg);
		}
		$this->duration = is_int($seg) ? $seg : $this->duration;
	}
	
	/**
	 * Get the title of the Event
	 * @return string
	 */
	public function getTitle(){
		return is_null($this->title)? '' : $this->title;
	}

	/**
	 * Set the title of the Event
	 * @param string $title
	 * 	new event title
	 */
	public function setTitle($title){ 
		$this->title = is_string($title) ? $title : $this->title; 
	}

	/**
	 * Get the Evnet code
	 * @return string
	 */
	public function getCode(){
		return $this->code;
	}

	/**
	 * Get the deadline participants are to RSVP by
	 * @return DateTime
	 */
	public function getDeadline(){
		return $this->deadline;
	}

	/**
	 * Set the deadline for participants to RSVP by
	 * @param string|DateTime $deadline
	 * 	-	string of a date
	 * 	-	DateTime
	 */
	public function setDeadline($deadline){
		if( is_string($deadline) ){
			$deadline = new DateTime($deadline);
		}
		$this->deadline = $deadline instanceof DateTime ? $deadline : $this->deadline;
	}


	/**
	 * Add Participants to the Event
	 * @param bool $type
	 * 	boolean:	true	parArray passed contains participants that have accepted the invitation to the event
	 * 				false	parArray passed contains participants that have declined the invitation to the event
	 * @param array $parArray
	 * 	array<string>
	 */
	public function addParticipants($type, $parArray){
		foreach($parArray as $person){
			if(!in_array($person, $this->participants[$type])){
				array_push($this->participants[$type], $person);
			}
		}
	}

	/**
	 * Get the participants to the Event
	 * @param bool $type
	 * 	boolean:	true	participants that have accepted the invitation to the event
	 * 				false	participants that have declined the invitation to the event
	 * @return array<string>
	 */
	public function getParticipants($type){
		return $this->participants[$type];
	}
}


class Day{

	private $date;
	private $time;

	/**
	 * Constructor
	 * Type 1: constructBlank
	 * 	@param	DateTime	$d	specific date
	 * 	@param		int			$t	1 == white mask, 0 == black mask
	 * Type 2: constructDay
	 * 	@param	String		$d	YYYY-MM-DD
	 * 	@param	String		$t	"00001100"
	 */
	function __construct($d, $t){
			$this->time = array();
			if(($d instanceof DateTime) && (is_int($t))){
				$this->constructBlank($d, $t);
			}else{
				$this->constructDay($d, $t);
			}
		}

		function constructBlank($dDateTime, $tInt){
			$this->date = $dDateTime;
			$tBool = (bool)$tInt;
			for($i = 0; $i < NUM_SEGMENTS; $i++){
				$this->time[$i] = $tBool;
			}
		}

		function constructDay($dString, $tString){
			$this->date = $dString instanceof DateTime? $dString : new DateTime($dString);	// esxpect YYYY-MM-DD to turn into system date
			$tString = str_split($tString);		// "00001100" ==> ["0"]["0"]["0"]["0"]["1"]["1"]["0"]["0"]
			foreach($tString as $t){			// ["0"]["0"]["0"]["0"]["1"]["1"]["0"]["0"] ==> [F][F][F][T][T][F][F]
				array_push($this->time, (bool)$t);
			}
	}

	/**
	 * @return array<boolean>
	 */
	public function getTime(){
		return $this->time;
	}

	/**
	 * @param array<boolean> $tArray
	 */
	public function setTime($tArray){
		if(is_bool(current($tArray))){
			$this->time = $tArray;
		}
	}

	/**
	 * @param int $t index
	 * @return boolean
	 */
	public function getAvailibility($t){
		return $this->time[$t];
	}
	/**
	 * @param boolean $type
	 * @param string $start_time
	 * 	hhmm ie '1130' is 11:30AM 
	 * @param string $end_time
	 * hhmm ie '1745' is 5:45PM
	 */
	public function setAvailiblity($type, $start_time, $end_time){
			//start index
			preg_match('/^(\d{2})(\d{2})$/', $start_time, $start_index);
			$start_index = intval(intval($start_index[1])*4+intdiv(intval($start_index[2]), 15));
	
			//end index
			preg_match('/^(\d{2})(\d{2})$/', $end_time, $end_index);
			$end_index = intval(intval($end_index[1])*4+ceil((intval($end_index[2])/ 15)));

			while($start_index <= $end_index){
				$this->time[$start_index] = $type;
				$start_index++;
			}
	}
	/**
	 * prints to bowser window a bisic difinition of the Day
	 * (for debugging)
	 */
	public function var_dump(){
		echo '<div style = "display:block; font-family: Lucida Console, Courier, monospace; font-size: .50em;" >';
		echo $this->date->format('Ymd') .' => [';
		foreach($this->time as $t){
			echo $t ? 'T' : 'F';
		}
		echo ']</div>';
	}

	/**
	 * Returns a string of the bisic difinition of the Day
	 * (for SQL LOG)
	 */
	public function describe(){
		return $this->date->format('Y-m-d') . " => [" . $this->to_01() . "]";
	}

	/**
	 * converts the boolean time array to '0010'
	 * @return string
	 */
	public function to_01(){
		$_01 = '';
		foreach($this->time as $t){
			$_01 .= $t ? '1' : '0';
		}
		return $_01;
	}

	/**
	 * @return DateTime
	 */
	public function getDate(){
		return clone($this->date);
	}

	/**
	 * Get the index of the first true in the time array
	 * @return int
	 */
	public function getStart(){
		$t = 0;
		$found = $this->time[$t];
		while(!$found && $t < count($this->time)){
			$found = $this->time[$t++]; 
		}
		return $t--;
	}

	/**
	 * Get the index of the last true in the time array
	 * @return int
	 */
	public function getEnd(){
		$t = count($this->time)-1;
		$found = $this->time[$t];
		while(!$found && $t >= 0){
			$found = $this->time[$t--]; 
		}
		return $t++;
	}

	/**
	 * merge the given day with the current day
	 * @param Day $mergeDay
	 */
	public function merge($mergeDay){
		if($mergeDay instanceof Day){
			for($i = 0; $i < NUM_SEGMENTS; $i++){
				$this->time[$i] = $this->getAvailibility($i) && $mergeDay->getAvailibility($i);
			}
		}
	}
}


/** -------------------------------------------------------------------------------------
 *  ---------------- helper functions --------------------------------------------------- 
 *  ------------------------------------------------------------------------------------- */

	/**
	 * Converts a passed element to a consitant string
	 * @param $elem
	 * 	any element that needs to be turned into a simple string
	 * 	DateTime =>	"YYYY-MM-DD"
	 *  string =>	string
	 * 	null =>		''
	 * 		--- add more as needed
	 * @return string
	 */
	function toString($elem){
		$string = '';

		switch(true){
			case ($elem instanceof DateTime) :	$string = $elem->format("Y-m-d");
								break;
			case is_string($elem):		$string = $elem;
								break;
			case is_integer($elem):		$string = strval($elem);
								break;
			case is_null($elem):
			default: break;
		}

		return $string;
	}


	/**
	 * Turn the information entered from the Create Event page into the Days of the Event
	 * @param DateTime $date_start
	 * @param DateTime $date_end
	 * @param array $windown_selection
	 * 	array( '0:000', '0:001', '0:002', ...)
	 * 		prototype 'w:seg'
	 * 		w = int day_of_the_week
	 * 		seg = int index_of_the_time_of_day
	 */
	function selectionToDay($date_start, $date_end, $window_selections){
		$ONE_DAY = new DateInterval('P1D');
		// plain week --- Blank
		// 0 => [0000...]
		// 1 => [0000...]
		// 2 => [0000...]
		// 3 => [0000...]
		// 4 => [0000...]
		// 5 => [0000...]
		// 6 => [0000...]
		$plain_week = array();
		$string_0 = '';
		for($ii = 0; $ii < 96; $ii++){ $string_0 .= '0'; }
		for($i = 0; $i < 7; $i++){ array_push($plain_week, $string_0); }

		// plain week
		// 0 => [0000...]
		// 1 => [0000...]
		// 2 => [0010...]
		// 3 => [0110...]
		// 4 => [0000...]
		// 5 => [0000...]
		// 6 => [0000...]
		foreach($window_selections as $select){
			// selection sould be in the format of '0:000'
			if(preg_match('/^\d{1}:\d{3}$/', $select)){
				$s = explode(':', $select);
				$day_of_the_week = intval($s[0]);
				$time_of_day = intval($s[1]);

				$plain_week[$day_of_the_week][$time_of_day] = '1';
			}
		}
		// create all Day objects
		$days_array = array();
		while($date_start <= $date_end){
			$day_of_the_week = $date_start->format('w');
			array_push($days_array, new Day(clone $date_start, $plain_week[$day_of_the_week]));
			$date_start->add($ONE_DAY);
		}
		return $days_array;
	}


	/**
	 * determine if the 2 given days are the same
	 * @param Day $a
	 * @param Day $b 
	 */
	function sameDay($a, $b){
		if( ($a instanceof Day && $b instanceof Day) && $a->getDate() == $b->getDate){
			$a = $a->getTime();
			$b = $b->getTime();
			
			$i = 0;
			$same = true;
			while($i < NUM_SEGMENTS && $same){
				$same = $a[$i] == $b[$i];
				$i++;
			}
			return $same;
		}
		return false;
	}


?>