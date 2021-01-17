<?php
	include ("../PHP_Functions/User.php");
	include ("../PHP_Functions/Event.php");
	include ("../PHP_Functions/functions.php");
?>

<!DOCTYPE html>
<!-- ----------------- php prints htmlheader ----------------- -->
<?php	printHead('WhensDay | Home');	?>
<!-- ----------------- --------------------- ----------------- -->
	<body class = "grid_container_set_auto">
	<!-- ----------------- php prints navigation ----------------- -->
	<?php 	printNavigation();	?>
	<!-- ----------------- --------------------- ----------------- -->
	<main id="main">
		<h1>
		<span id = 'h1'>
			I'll check my schedule...
		</span>
			<!-- ----------------- php prints User Profile Acess ----------------- -->
			<?php 	 printUserButton(); ?>
			<!-- ----------------- ----------------------------- ----------------- -->
		
		</h1>
		<div class = "content"> 
		<ul class="list">
			<li>
				<div <a class="button big" >
					<a  href="Enter_RSVP.php?" >RSVP to an Event</a>
			</div>
		</li>
		<li>
			<div <a class="button big" >
			<a href="CreateEvent.php?">Create an Event</a>
			</div>
		</li>
		<li>
			<div <a class="button big" >
			<a href="../PHP_Functions/DB_Controller.php">Test</a>
			</div>
		</li>
		</ul>
		</div>
	</main>
	<footer>
		<div class = 'button small'>
		<a href = "admin_portal.php?admin=1">Admin Portal</a>
		</div>
	</footer>
	</body>
</html>