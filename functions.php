<?php
	function printNavigation(){
		$nav = "data/nav.txt";
		$myfile = fopen($nav, "r") or die("Unable to open file!");
		echo fread($myfile,filesize($nav));
		fclose($myfile);
	};

	function connectDB(){
		$host =  'localhost';	//cis444 server
		// $host =  'db';	// Local Server
		$userid =  'group4';
		$password = 'IjChbKtynlNZ';
		$schema =  'group4';

		$db = new mysqli($host, $userid,  $password, $schema);

		if ($db->connect_error){
			print "<p class = \"dbStatus\">Unable to Connect to MySQL</p>". $db -> connect_error;
			exit;
		}else{
			return $db;
		}
	};
?>
