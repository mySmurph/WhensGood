<?php

class DB_Controller{
	private $db;
	function __construct()
	{
		$host =  'db';	// Local Server
		$userid =  'WhensDay_Login';
		$password = '1234';
		$schema =  'WhensDay';
		try{
			$this->db =  new mysqli($host, $userid,  $password, $schema);
			if ($this->db->connect_error) {
				$this->db = false;
				alert(false, "Could not Connect to Database");
			}
		}catch(mysqli_sql_exception $e){
			throw $e; 
		}
	}

	/**
	 * @param string $code
	 * @return boolean
	 */
	public function eventExist($code){
		$sql = "SELECT count(Distinct EventCode) as Exist from Events Where EventCode = '$code';";
		$result = $this->read($sql);
		return !$result ? false : intval(array_values($result[0])[0])==1;
	}

	/**
	 * @param string $code
	 * @return Event
	 */
	public function getEvent($code){
		$sql = "SELECT EventTitle, Duration, Deadline FROM Events Where EventCode = '$code' limit 1;";
		$result = $this->read($sql);
		if(is_array($result)){
			$result = $result[0];
			$days = $this->getDays($code);
			return new Event($days, $code, $result[0],$result[1], $result[2]);
		}
		return null;
	}

	public function getCalendarsFiles($code){
		$sql = "SELECT CalenderFile FROM EventParticipant WHERE EventCode ='$code' AND Responce = TRUE;";
		$result = $this->read($sql);
		$files = array();

		if(is_array($result)){
			foreach($result as &$filename){
				array_push($files, $filename[0]);
			}
			unset($filename);
		}
		return $files;
	}
	public function getParticipant($code, $type){
		$type = $type ? 1 : 0 ;
		$sql = "SELECT Display_Name FROM Users u, EventParticipant p WHERE u.username = p.EventParticipant AND EventCode ='$code' AND Responce = $type;";
		$result = $this->read($sql);
		$people = array();

		if(is_array($result)){
			foreach($result as &$person){
				array_push($people, $person[0]);
			}
			unset($person);
		}
		return $people;
	}

	/**
	 * @param string $code
	 * @return array('title' => string, 'duration' => int, 'deadline' =>  DateTime)
	 */
	private function getEvent_Prototype($code){
		$sql = "SELECT EventTitle, Duration, Deadline FROM Events Where EventCode = '$code' limit 1;";
		$result = $this->read($sql);
		if(is_array($result)){
			$result = $result[0];
			return array('title' => $result[0], 'duration' => intval($result[1]), 'deadline' => new DateTime($result[2]));
		}
		return null;
	}
	
	/**
	 * @param string $code
	 * @return false|array(['Y-m-d, '0010']...)
	 */
	public function getDays($code){
		$sql = "SELECT	EventDate, TimeArray FROM Days Where EventCode = '$code';";
		return $this->read($sql);
	}

	/**
	 * @param string $username
	 * @return boolean
	 */
	public function usernameExist($user){
		$sql = "SELECT count(Distinct username) as Exist from Users Where username = '$user';";
		$result = $this->read($sql);
		return !$result ? false : intval(array_values($result[0])[0])==1;
	}

	/**
	 * @param string $email
	 * @return boolean
	 */
	public function emailExist($email){
		$sql = "SELECT count(Distinct email) as Exist from Users Where email = '$email';";
		$result = $this->read($sql);
		return !$result ? false : intval(array_values($result[0])[0])==1;
	}

	/**
	 * @param string $userID
	 * @param string $password
	 * @return false|string
	 */
	public function userExist($userID, $password){
		$sql = "SELECT DISTINCT username FROM Users WHERE user_type = 'U' AND (email = '$userID' OR BINARY username = '$userID') AND Password = MD5('$password');";
		$result = $this->read($sql);

		return !$result ? null : ($result[0][0] == '' ? null :array_values($result[0])[0]);
	}

	/**
	 * @param string $username
	 * @return User
	 */
	public function getUser($username){
		$sql = "SELECT Distinct username, Display_Name, email FROM Users WHERE Binary username = '$username' LIMIT 1;";
		$result = $this->read($sql);
		if(is_array($result)){
			$result = $result[0];
			$user = new User($result[0], $result[1], $result[2]);
			$user->setEvents($this->getMyEvents($username));
			return $user;
		}
		return null;
	}

	/**
	 * @param string $username
	 * @param string $code
	 * @return boolean
	 */
	public function isMyEvent($username, $code){
		$sql = "SELECT COUNT(distinct EventCode) FROM Events WHERE EventOrganizer = '$username' AND EventCode = '$code';";
		$result = $this->read($sql);
		return !$result ? null : ($result[0][0] == '' ? null :array_values($result[0])[0]);
	}

	/**
	 * @param string $username
	 * @return array<string>
	 */
	public function getMyEvents($username){
		$sql = "SELECT EventCode FROM Events WHERE EventOrganizer = '$username';";
		$result = $this->read($sql);
		$events = array();
		if(is_array($result)){
			// var_dump($result);
			foreach($result as $eventCode){
				// var_dump($eventCode[0]);
				$events[$eventCode[0]] = $this->getEvent($eventCode[0]);
			}
		}
		return $events;
	}

	/**
	 * @param string $sql_query
	 * @return false|array<array>
	 */
	private function read($sql_query){
		if(!$this->db){
			return false;
		}
		$responce = $this->db->query($sql_query);
	
		if(!$responce ||  mysqli_num_rows($responce) < 1){
			return false;
		}
		$numresults = mysqli_num_rows($responce);
		$results = array();
		for($i = 0; $i < $numresults; $i++){
			array_push($results, array_values(mysqli_fetch_assoc($responce)));
		}
		return $results;
	}
	
	/**
	 * @param string $username
	 * @param Event $event
	 * @return boolean
	 */
	public function writeEvent($username, $event){
		//check to see if this event already exist
		if($this->eventExist($event->getCode())){
			//if the event exist we will try to update the envent
			// BUT first will see if the user provided is the organizer of the event
			if($this->isMyEvent($username, $event->getCode())){
				//try to update event instead
				return $this->updateEvent($username, $event);
			}else{
				//this is not their event and they dont have permission to update the event, do not insert, do not udate, just send them back
				alert(false, __FUNCTION__ . " -> " ."You do not have permission to alter this event");
			}

		}else{ //if it does not exist then insert the event
			return $this->insertEvent($username, $event);
		}
		return false;
	}

	/**
	 * @param string $username
	 * @param Event $event
	 * @return boolean
	 */
	private function updateEvent($username, $event){
		$code = $event->getCode();
		$old_event = $this->getEvent($code);

		$sql_s = array();
		$log_message = "UPDATE Event\r\nFROM\r\n" . $old_event->describe() ."\r\nTO\r\n". $event->describe();

		// determine event details to be updates
		$update_event_set = array();
		if($event->getTitle() != $old_event->getTitle()){
			//update Title
			array_push($update_event_set, "EventTitle = '" . $event->getTitle() . "'");
		}
		if($event->getDuration() != $old_event->getDuration()){
			//update durration
			array_push($update_event_set, "Duration = " . $event->getDuration() . "");
		}
		if($event->getDeadline() != $old_event->getDeadline()){
			//update deadline
			array_push($update_event_set, "Deadline = '" . toString($event->getDeadline()) . "'");
		}
		//---- SQL -- UPDATE Events SET EventTitle = '', Duration = '', Deadline = ''  WHERE EventCode = '$code';
		if(count($update_event_set) > 0){
			$update_event_set = implode(', ', $update_event_set);
			array_push( $sql_s, "UPDATE Events SET $update_event_set WHERE EventCode = '$code';" );
		}


		//detrermin days to be updated or inserted
		$insert_days = array();
		foreach($event->getDays() as $new_day){
			$old_day = $old_event->getDayByDate($new_day->getDate());
			if(!is_null($old_day)){
			//day exits in old event 
				if(!sameDay($new_day, $old_day)){
				// if day is different: update
					$date = toString($new_day->getDate());
					$time_01 = $new_day->to_01();
					//---- SQL -- UPDATE Days SET TimeArray = '' WHERE EventCode = '$code' AND EventDate = '$date';
					array_push($sql_s, "UPDATE Days SET TimeArray = '$time_01 ' WHERE EventCode = '$code' AND EventDate = '$date';");
				}
				//remove day from old
				$old_event->removeDayByDate($new_day->getDate());
			}else{
			//day does not exist : insert
				$date = toString($new_day->getDate());
				$time_01 = $new_day->to_01();
				array_push($insert_days, "( '$code', '$date', '$time_01' )");
			}
		}
		//---- SQL -- INSERT INTO Days( EventCode, EventDate, TimeArray) VALUES ('', '', ''), ('', '', ''), ...;
		if(count($insert_days) > 0){
			array_push($sql_s, "INSERT INTO Days( EventCode, EventDate, TimeArray) VALUES " . implode(", ", $insert_days) . ";");
		}
				
		//determin days that are no longer part of the event
		$delete_days = array();
		foreach($old_event->getDays() as $day){
			array_push($delete_days, "EventDate = '" . toString($day->getDate()) . "'");  
		}
		//---- SQL -- DELETE FROM Days WHERE EventCode = '$code' AND EventDate = '' OR EventDate = '' OR EventDate = '' OR ... ;
		if(count($delete_days) > 0){
			$delete_days_OR = implode(' OR ', $delete_days);
			array_push($sql_s, "DELETE FROM Days WHERE EventCode = '$code' AND $delete_days_OR ;");
		}

		$successfull = true;
		//determine if there are actual changes that we determined to be made - if true we need to log the change
		//then start running the queries
		//---- SQL -- INSERT INTO LOGS( AssociatedUserID, DateTime, Description ) VALUES('', '', '');
		if(count($sql_s) > 0){
			array_push($sql_s,"INSERT INTO LOGS(AssociatedUserID, DateTime, Description ) VALUES('$username',  NOW(), '$log_message');");
			foreach($sql_s AS &$query){
				$successfull = $successfull && ($query != '' ? $this->write($query) : true);

				if(!$successfull){
					alert(false, __FUNCTION__ . " -> " . $query);
					break;
				}
			}
			unset($query);
		}
		return $successfull;
	}
	
	/**
	 * @param string $username
	 * @param Event $event
	 * @return boolean
	 */
	private function insertEvent($username, $event){
		$query_string  = $this->getSQLQuery("Insert_Event");
		if(!$query_string){
			alert(false, __FUNCTION__);
			return false;
		}
		$placeholders = array(
			'$username',
			'$EventCode',
			'$EventTitle',
			'$duration',
			'$deadline',
			'$Days'
		);
		$values = array(
			toString($username),
			toString($event->getCode()),
			toString($event->getTitle()),
			toString($event->getDuration()),
			toString($event->getDeadline()),
			$this->dayToSQL($event)
		);
		$query_string = str_replace($placeholders, $values, $query_string);
		$successfull = true;
		
		foreach(explode("<br>", $query_string) as $query){
			$successfull = $successfull && ($query != '' ? $this->write($query) : true);

			if(!$successfull){
				alert(false, __FUNCTION__ . " -> " . $query);
				break;
			}
		}
		return $successfull;
	}

	/**
	 * Converts Day(s) of an Event into a string that can be used to insert it into a SQL database
	 * @return string
	 * "('code', 'YYYY-MM-DD', '0010'), ('', '', ''), ('', '', ''), ..."
	 */
	private function dayToSQL($event){
		$code = $event->getCode();
		$days = $event->getDays();
		$days_string = array();
		foreach($days as $d){
			$date = toString($d->getDate());
			$time_string = $d->to_01();
			array_push($days_string, "('$code', '$date', '$time_string')");
		}
		return implode(', ', $days_string);
	}

	/**
	 * @param User $user
	 * @param string $password
	 * @return boolean
	 */
	public function insertUser($user, $password){
		$query_string  = $this->getSQLQuery("Insert_User");
		if(!$query_string){
			alert(false, __FUNCTION__);
			return false;
		}
		$placeholders = array(
			'$username',
			'$Display_Name',
			'$email',
			'$password'
		);
		$values = array(
			$user->getUsername(),
			$user->getDisplayName(),
			$user->getEmail(),
			$password
		);
		$query_string = str_replace($placeholders, $values, $query_string);
		// alert(true, $query_string);
		$successfull = true;
		
		foreach(explode("<br>", $query_string) as $query){
			$successfull = $successfull && ($query != '' ? $this->write($query) : true);

			if(!$successfull){
				alert(false, __FUNCTION__ . " -> " . $query);
				break;
			}
		}
		return $successfull;

	}
	

	public function insertParticpant($code, $userID, $rsvp, $calendar){
		$rsvp = $rsvp ? 1: 0;
		$sql_s = array();
		array_push($sql_s, "REPLACE INTO EventParticipant SET EventCode = '$code', EventParticipant = '$userID', Responce = $rsvp, CalenderFile = '$calendar';");
		array_push($sql_s,"INSERT INTO LOGS(AssociatedUserID, DateTime, Description ) VALUES('$userID',  NOW(), 'Participan RSVP to Event\n $code -> $userID [RSVP = $rsvp, FILE = $calendar]');");
		$successfull = true;
		foreach($sql_s as &$query){
			$successfull = $successfull && ($query != '' ? $this->write($query) : true);

			if(!$successfull){
				alert(false, __FUNCTION__ . " -> " . $query);
				break;
			}
		}
		unset($query);
		return $successfull;
	}

	/**
	 * @param string $queryFunction
	 * 	the name the query file in the ../MySQL path without the file extention
	 * @return string
	 */
	private function getSQLQuery($queryFunction){
		$file_path = "../MySQL/$queryFunction.sql";
		$file = fopen($file_path, "r");
		if(!$file){
			alert(false, __FUNCTION__."(".$queryFunction.")");
			return false;
		}
		$query_string = fread($file,filesize($file_path));
		fclose($file);
		return $query_string;

	}

	/**
	 * @param $sql_query
	 * @return false|null
	 */
	private function write($sql_query){
		if(!$this->db){
			return false;
		}
		return $this->db->real_query($sql_query);
	}
}

?>
