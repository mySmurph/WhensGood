<?php
class User{
	private $username;	//string
	private $name;		//string
	private $email;		//string
	private $events;	//array<string>

	/**
	 * @param string|null $username
	 * 	if null a unique UserID is generated
	 * @param string|null $name
	 * @param string|null $email
	 */
	function __construct($username = null, $name = null, $email = null){
		$this->username = !is_null($username) ? $username : base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
		$this->name = $name;
		$this->email = $email;
		$this->events = array();
	}

	/* -----getters and setters--------------------------------------------------------------------------- */
		/**
		 * @return string
		 */
		function getUsername(){	return $this->username;}

		/**
		 * @param string $newUsername
		 */
		function setUsername($newUserame){ $this->username = $newUserame;}
		
		/**
		 * @return string
		 */
		function getDisplayName(){	return $this->name;}

		/**
		 * @param string $newName
		 */
		function setDisplayName($newName){ $this->name = $newName;}

		/**
		 * @return string
		 */
		function getEmail(){	return $this->email;}

		/**
		 * @param string $newEmail
		 */
		function setEmail($newEmail){ $this->email = $newEmail;}

		/**
		 * @return array<Event>
		 */

		 function getEvents(){	return $this->events;}
		 function getEvent($index){	return $this->events[$index];}
		/**
		 * @param Event $events
		 */
		function setEvents($events){ $this->events = $events;}
	/* --------------------------------------------------------------------------------------------------- */


	function var_dump(){
		echo "
		Username: $this->username <br/>
		Display Name : $this->name <br/>
		User's Email: $this->email <br/>
		Events:<br/>
		";
		foreach($this->events as &$e){
			$e->var_dump();
		}
		unset($e);
	}
}

class UserPrinter{

}
?>