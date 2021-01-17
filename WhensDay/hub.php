<?php 
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/DB_Controller.php");
	include ("../PHP_Functions/functions.php");

	$source = $_POST['source'];
	$destination = $_POST['destination'];
	
	if($destination == 'CreateEvent.php'){
		unset($_SESSION["thisEventObject"]);
	}


	$defualtDestination = 'index.php';

	$eventFound = true;

	header('Location: '. $destination);

?>