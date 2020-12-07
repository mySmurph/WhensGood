<?php 
  if(session_status() !== PHP_SESSION_ACTIVE) session_start();
	include ("functions.php");

	$source = $_POST['source'];
	$destination = $_POST['destination'];

	$code = $_POST['event_code'];
	$password = $_POST['password_input'];

	$defualtDestination = 'index.php';

	$eventFound = true;


	if($source == "admin_portal.php"){
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$_SESSION['access'] = validateAdmin($user, $pass);
		$destination = $_SESSION['access'] ? $destination: $source;

	}else{
		if(!isset($destination) || !isset($code)){
			$destination = $defualtDestination;
		}else{
			$eventFound = $password =='' ? validateCode($code) :validateOrganizer($code, $password);
			$destination = $eventFound? $destination : $source.'?found=0';
		}
		$_SESSION["event_code"] = $code;
		$_SESSION["eventFound"] = $eventFound;
	}
	header('Location: '. $destination);

?>