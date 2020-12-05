<!--  https://cis444.cs.csusm.edu/group4/WhensGood/RSVP.php -->
<!-- T.V. PASS! -->
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<!--<meta charset = "UTF-8"/> not necessary according to Total Validator-->
  <title>RSVP To Event</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
	
<?php 
	include ("functions.php");
	printNavigation();
	?>
  
    <main id="main">
        <h1>
            RSVP to Event
        </h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="grid_container">
				<div>
					<ul class = "inline_list">
						<li>
							<label aria-label="Deadline to RSVP">RSVP Deadline<br/></label>
							<input id="rsvp_deadline" class="text_input" type="date" readonly="readonly"  aria-label="rsvp_deadline" />
						</li>
						<li>
							<label>Event Duration</label><br/>
							<div class="text_input">
								<input type="number" class="durration_time" id="hr" min="0" max="12" value="0" readonly="readonly" aria-label="Hours"/>HR
								<input type="number" class="durration_time" id="min" min="0" max="60" step="15" value="0" readonly="readonly" aria-label="Minutes"/>MIN
								&nbsp;&nbsp;&nbsp;
							</div>
						</li>
					</ul>
					<label>Event Windows</label>
					<?php 

	
$eventWindow = array(
	array('20201124', '000000000000000000000000000000000000000000000000111111111111111111111111111000000000000000000000'), 
	array('20201125', '000000000000000000000000000000000000000000000000111111111111111111111111111000000000000000000000'),
	array('20201126', '000000000000000000000000000000000000000000000011111111111111111111110000000000000000000000000000'),
	array('20201127', '000000000000000000000000000000000000000000000000111111111111111111111111111000000000000000000000'), 
	array('20201128', '000000000000000000000000000000000000000000000000001111111111111111111111111000000000000000000000'),
	array('20201129', '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'),
	array('20201130', '000000000000000000000000000000000000000000000000000111111111111111000000000000000000000000000000')
);

$dw = new  DateWindows();

$eventWindow = $dw->eventToBoolWeek($eventWindow);

$dw->printCalendarBlock($eventWindow);


?>
				</div>
				<div>
					<ul>
						<li>
							<label>Participant's Name<br/>
							<input class="text_input full" type="text" id="name"/></label>
						</li>
						<li>
							<label>Participant's Email<br />
							<input class="text_input full" type="email" id="email"/></label>
						</li>
						<li>
							<label>Accept Event Participation<br/>
							</label>
							<div class="switchbox">
										<div class = "label">Decline</div>
										<input type="checkbox" id="switchbox" data-check-switch aria-label="rsvp"/>
										<div class = "label">Accept</div>
							</div>
							
						</li>
						<li>
							<label aria-label="Upload your calendar">Participant's Calendar<br/></label>
							
								<label class="custom_file_upload" for="cal_upload">
									<span class="file_upload_button_text">Browse</span>
								</label>
									<input type="text" class="text_input full" readonly="readonly" id="choose_file" aria-label="file field" />
									<input id="cal_upload" name="cal_upload" class="create" type="file" aria-label="Browse" />
						</li>
						<li>
							<button class="button red span" id = "button">RSVP to Event</button>
						</li>
					</ul>
				</div>
			</div>

					<!-- Generated userID : hidden from user -->
					<?php
						$userID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
						echo "<input type=\"hidden\" id = \"userID\" name = \"userID\" value = \"".$userID."\" >"
					?>
        </form>
  </main>

	<script type="text/javascript" src="script/rsvp_to_event.js"></script>
</body>
</html>