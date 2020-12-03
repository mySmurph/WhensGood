
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
	printNavigtion();
	?>
  
    <main id="main">
      <h1>
        I'll check my schedule...
      </h1>
       <div class = "content"> 
            <ul class="list">
                <li>
                    <a class="button big" href="enter-rsvp.html" >RSVP to an Event</a>
                </li>
                <li>
                    <a class="button big" href="create_event.html">Create an Event</a>
                </li>
            </ul>
        </div>
    </main>
  
</body>
</html>