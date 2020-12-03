<?php
	function printNavigtion(){
		$nav = "data/nav.txt";
		$myfile = fopen($nav, "r") or die("Unable to open file!");
		echo fread($myfile,filesize($nav));
		fclose($myfile);
	};
?>
