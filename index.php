<?php
  if(session_status() !== PHP_SESSION_ACTIVE) session_start();
  $_SESSION['access'] = false;
  unset($_SESSION["event_code"]);
  unset($_SESSION["eventFound"]);
  session_destroy();
?>
<!--  http://cis444.cs.csusm.edu/group4/WhensGood/landing.html  -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
  <title>Home Page</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
</head>

<body>
	
<?php 
	include ("functions.php");
	printNavigation();
	?>
  
    <main id="main">
      <h1>
        I'll check my schedule...
      </h1>
       <div class = "content"> 
            <ul class="list">
                <li><div <a class="button big" >
                    <a  href="Enter_RSVP.php" >RSVP to an Event</a>
                </div></li>
                <li><div <a class="button big" >
                    <a href="CreateEvent.php">Create an Event</a>
                  </div></li>
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