<?php 
session_start();
	include ("functions.php");

	$source = $_POST['source'];
	$destination = $_POST['destination'];

	$code = $_POST['event_code'];
	$password = $_POST['password_input'];

	$defualtDestination = 'index.php';

	$eventFound = true;

	if(!isset($destination) || !isset($code)){
		$destination = $defualtDestination;
	}else{
		$eventFound = $password =='' ? validateCode($code) :validateOrganizer($code, $password);
		$destination = $eventFound? $destination:$source;
	}
	$_SESSION["event_code"] = $code;
	$_SESSION["eventFound"] = $eventFound;
	// var_dump($_POST);
	// var_dump($destination);
	header('Location: '. $destination);

?>