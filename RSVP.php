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
	printNavigtion();
	?>
  
    <main id="main">
        <h1>
            RSVP to Event
        </h1>
        <form>
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
					<div id = "hour_table_00" class="hour_table  white">
						<ol class="times">
							<li class = "date"></li>
							<li class="time">04:00 PM</li>
							<li class="time">05:00 PM</li>
							<li class="time">06:00 PM</li>
							<li class="time">07:00 PM</li>
						</ol>
						<ol class = "selectable_list" id="selectable-SUN-00">
							<li class = "date">SUN<span>11/1/2020</span></li>
							<li class="segment  window" id="SUN-00-1600">SUN-1600</li>
							<li class="segment  window" id="SUN-00-1615">SUN-1615</li>
							<li class="segment  window" id="SUN-00-1630">SUN-1630</li>
							<li class="segment  window" id="SUN-00-1645">SUN-1645</li>
							<li class="segment  window" id="SUN-00-1700">SUN-1700</li>
							<li class="segment  window" id="SUN-00-1715">SUN-1715</li>
							<li class="segment  window" id="SUN-00-1730">SUN-1730</li>
							<li class="segment  window" id="SUN-00-1745">SUN-1745</li>
							<li class="segment  window" id="SUN-00-1800">SUN-1800</li>
							<li class="segment  window" id="SUN-00-1815">SUN-1815</li>
							<li class="segment" id="SUN-00-1830">SUN-1830</li>
							<li class="segment" id="SUN-00-1845">SUN-1845</li>
							<li class="segment" id="SUN-00-1900">SUN-1900</li>
							<li class="segment" id="SUN-00-1915">SUN-1915</li>
							<li class="segment" id="SUN-00-1930">SUN-1930</li>
							<li class="segment" id="SUN-00-1945">SUN-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-MON-01">
							<li class = "date">MON<span>11/2/2020</span></li>
							<li class="segment" id="MON-01-1600">MON-1600</li>
							<li class="segment" id="MON-01-1615">MON-1615</li>
							<li class="segment" id="MON-01-1630">MON-1630</li>
							<li class="segment" id="MON-01-1645">MON-1645</li>
							<li class="segment" id="MON-01-1700">MON-1700</li>
							<li class="segment" id="MON-01-1715">MON-1715</li>
							<li class="segment" id="MON-01-1730">MON-1730</li>
							<li class="segment" id="MON-01-1745">MON-1745</li>
							<li class="segment" id="MON-01-1800">MON-1800</li>
							<li class="segment" id="MON-01-1815">MON-1815</li>
							<li class="segment" id="MON-01-1830">MON-1830</li>
							<li class="segment" id="MON-01-1845">MON-1845</li>
							<li class="segment" id="MON-01-1900">MON-1900</li>
							<li class="segment" id="MON-01-1915">MON-1915</li>
							<li class="segment" id="MON-01-1930">MON-1930</li>
							<li class="segment" id="MON-01-1945">MON-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-TUE-02">
							<li class = "date">TUE<span>11/3/2020</span></li>
							<li class="segment" id="TUE-02-1600">TUE-1600</li>
							<li class="segment" id="TUE-02-1615">TUE-1615</li>
							<li class="segment" id="TUE-02-1630">TUE-1630</li>
							<li class="segment" id="TUE-02-1645">TUE-1645</li>
							<li class="segment" id="TUE-02-1700">TUE-1700</li>
							<li class="segment" id="TUE-02-1715">TUE-1715</li>
							<li class="segment" id="TUE-02-1730">TUE-1730</li>
							<li class="segment" id="TUE-02-1745">TUE-1745</li>
							<li class="segment" id="TUE-02-1800">TUE-1800</li>
							<li class="segment" id="TUE-02-1815">TUE-1815</li>
							<li class="segment" id="TUE-02-1830">TUE-1830</li>
							<li class="segment" id="TUE-02-1845">TUE-1845</li>
							<li class="segment" id="TUE-02-1900">TUE-1900</li>
							<li class="segment" id="TUE-02-1915">TUE-1915</li>
							<li class="segment" id="TUE-02-1930">TUE-1930</li>
							<li class="segment" id="TUE-02-1945">TUE-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-WED-03">
							<li class = "date">WED<span>11/4/2020</span></li>
							<li class="segment" id="WED-03-1600">WED-1600</li>
							<li class="segment" id="WED-03-1615">WED-1615</li>
							<li class="segment" id="WED-03-1630">WED-1630</li>
							<li class="segment" id="WED-03-1645">WED-1645</li>
							<li class="segment" id="WED-03-1700">WED-1700</li>
							<li class="segment" id="WED-03-1715">WED-1715</li>
							<li class="segment" id="WED-03-1730">WED-1730</li>
							<li class="segment" id="WED-03-1745">WED-1745</li>
							<li class="segment" id="WED-03-1800">WED-1800</li>
							<li class="segment" id="WED-03-1815">WED-1815</li>
							<li class="segment" id="WED-03-1830">WED-1830</li>
							<li class="segment" id="WED-03-1845">WED-1845</li>
							<li class="segment" id="WED-03-1900">WED-1900</li>
							<li class="segment" id="WED-03-1915">WED-1915</li>
							<li class="segment" id="WED-03-1930">WED-1930</li>
							<li class="segment" id="WED-03-1945">WED-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-THR-04">
							<li class = "date">THR<span>11/5/2020</span></li>
							<li class="segment" id="THR-04-1600">THR-1600</li>
							<li class="segment" id="THR-04-1615">THR-1615</li>
							<li class="segment" id="THR-04-1630">THR-1630</li>
							<li class="segment" id="THR-04-1645">THR-1645</li>
							<li class="segment" id="THR-04-1700">THR-1700</li>
							<li class="segment" id="THR-04-1715">THR-1715</li>
							<li class="segment" id="THR-04-1730">THR-1730</li>
							<li class="segment" id="THR-04-1745">THR-1745</li>
							<li class="segment" id="THR-04-1800">THR-1800</li>
							<li class="segment" id="THR-04-1815">THR-1815</li>
							<li class="segment" id="THR-04-1830">THR-1830</li>
							<li class="segment" id="THR-04-1845">THR-1845</li>
							<li class="segment" id="THR-04-1900">THR-1900</li>
							<li class="segment" id="THR-04-1915">THR-1915</li>
							<li class="segment" id="THR-04-1930">THR-1930</li>
							<li class="segment" id="THR-04-1945">THR-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-FRI-05">
							<li class = "date">FRI<span>11/6/2020</span></li>
							<li class="segment" id="FRI-05-1600">FRI-1600</li>
							<li class="segment" id="FRI-05-1615">FRI-1615</li>
							<li class="segment  window" id="FRI-05-1630">FRI-1630</li>
							<li class="segment  window" id="FRI-05-1645">FRI-1645</li>
							<li class="segment  window" id="FRI-05-1700">FRI-1700</li>
							<li class="segment  window" id="FRI-05-1715">FRI-1715</li>
							<li class="segment  window" id="FRI-05-1730">FRI-1730</li>
							<li class="segment  window" id="FRI-05-1745">FRI-1745</li>
							<li class="segment  window" id="FRI-05-1800">FRI-1800</li>
							<li class="segment  window" id="FRI-05-1815">FRI-1815</li>
							<li class="segment  window" id="FRI-05-1830">FRI-1830</li>
							<li class="segment  window" id="FRI-05-1845">FRI-1845</li>
							<li class="segment  window" id="FRI-05-1900">FRI-1900</li>
							<li class="segment  window" id="FRI-05-1915">FRI-1915</li>
							<li class="segment  window" id="FRI-05-1930">FRI-1930</li>
							<li class="segment  window" id="FRI-05-1945">FRI-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-SAT-06">
							<li class = "date">SAT<span>11/7/2020</span></li>
							<li class="segment" id="SAT-06-1600">SAT-1600</li>
							<li class="segment" id="SAT-06-1615">SAT-1615</li>
							<li class="segment" id="SAT-06-1630">SAT-1630</li>
							<li class="segment" id="SAT-06-1645">SAT-1645</li>
							<li class="segment  window" id="SAT-06-1700">SAT-1700</li>
							<li class="segment  window" id="SAT-06-1715">SAT-1715</li>
							<li class="segment  window" id="SAT-06-1730">SAT-1730</li>
							<li class="segment  window" id="SAT-06-1745">SAT-1745</li>
							<li class="segment  window" id="SAT-06-1800">SAT-1800</li>
							<li class="segment  window" id="SAT-06-1815">SAT-1815</li>
							<li class="segment  window" id="SAT-06-1830">SAT-1830</li>
							<li class="segment  window" id="SAT-06-1845">SAT-1845</li>
							<li class="segment  window" id="SAT-06-1900">SAT-1900</li>
							<li class="segment  window" id="SAT-06-1915">SAT-1915</li>
							<li class="segment  window" id="SAT-06-1930">SAT-1930</li>
							<li class="segment  window" id="SAT-06-1945">SAT-1945</li>
						</ol>

						<ol class="times">
							<li class = "date"></li>
							<li class="time">04:00 PM</li>
							<li class="time">05:00 PM</li>
							<li class="time">06:00 PM</li>
							<li class="time">07:00 PM</li>
						  </ol>
						  <ol class = "selectable_list" id="selectable-SUN-07">
							<li class = "date">SUN<span>11/8/2020</span></li>
							<li class="segment  window" id="SUN-07-1600">SUN-1600</li>
							<li class="segment  window" id="SUN-07-1615">SUN-1615</li>
							<li class="segment  window" id="SUN-07-1630">SUN-1630</li>
							<li class="segment  window" id="SUN-07-1645">SUN-1645</li>
							<li class="segment  window" id="SUN-07-1700">SUN-1700</li>
							<li class="segment  window" id="SUN-07-1715">SUN-1715</li>
							<li class="segment  window" id="SUN-07-1730">SUN-1730</li>
							<li class="segment  window" id="SUN-07-1745">SUN-1745</li>
							<li class="segment  window" id="SUN-07-1800">SUN-1800</li>
							<li class="segment  window" id="SUN-07-1815">SUN-1815</li>
							<li class="segment" id="SUN-07-1830">SUN-1830</li>
							<li class="segment" id="SUN-07-1845">SUN-1845</li>
							<li class="segment" id="SUN-07-1900">SUN-1900</li>
							<li class="segment" id="SUN-07-1915">SUN-1915</li>
							<li class="segment" id="SUN-07-1930">SUN-1930</li>
							<li class="segment" id="SUN-07-1945">SUN-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-MON-08">
							<li class = "date">MON<span>11/9/2020</span></li>
							<li class="segment" id="MON-08-1600">MON-1600</li>
							<li class="segment" id="MON-08-1615">MON-1615</li>
							<li class="segment" id="MON-08-1630">MON-1630</li>
							<li class="segment" id="MON-08-1645">MON-1645</li>
							<li class="segment" id="MON-08-1700">MON-1700</li>
							<li class="segment" id="MON-08-1715">MON-1715</li>
							<li class="segment" id="MON-08-1730">MON-1730</li>
							<li class="segment" id="MON-08-1745">MON-1745</li>
							<li class="segment" id="MON-08-1800">MON-1800</li>
							<li class="segment" id="MON-08-1815">MON-1815</li>
							<li class="segment" id="MON-08-1830">MON-1830</li>
							<li class="segment" id="MON-08-1845">MON-1845</li>
							<li class="segment" id="MON-08-1900">MON-1900</li>
							<li class="segment" id="MON-08-1915">MON-1915</li>
							<li class="segment" id="MON-08-1930">MON-1930</li>
							<li class="segment" id="MON-08-1945">MON-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-TUE-09">
							<li class = "date">TUE<span>11/10/2020</span></li>
							<li class="segment" id="TUE-09-1600">TUE-1600</li>
							<li class="segment" id="TUE-09-1615">TUE-1615</li>
							<li class="segment" id="TUE-09-1630">TUE-1630</li>
							<li class="segment" id="TUE-09-1645">TUE-1645</li>
							<li class="segment" id="TUE-09-1700">TUE-1700</li>
							<li class="segment" id="TUE-09-1715">TUE-1715</li>
							<li class="segment" id="TUE-09-1730">TUE-1730</li>
							<li class="segment" id="TUE-09-1745">TUE-1745</li>
							<li class="segment" id="TUE-09-1800">TUE-1800</li>
							<li class="segment" id="TUE-09-1815">TUE-1815</li>
							<li class="segment" id="TUE-09-1830">TUE-1830</li>
							<li class="segment" id="TUE-09-1845">TUE-1845</li>
							<li class="segment" id="TUE-09-1900">TUE-1900</li>
							<li class="segment" id="TUE-09-1915">TUE-1915</li>
							<li class="segment" id="TUE-09-1930">TUE-1930</li>
							<li class="segment" id="TUE-09-1945">TUE-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-WED-10">
							<li class = "date">WED<span>11/11/2020</span></li>
							<li class="segment" id="WED-10-1600">WED-1600</li>
							<li class="segment" id="WED-10-1615">WED-1615</li>
							<li class="segment" id="WED-10-1630">WED-1630</li>
							<li class="segment" id="WED-10-1645">WED-1645</li>
							<li class="segment" id="WED-10-1700">WED-1700</li>
							<li class="segment" id="WED-10-1715">WED-1715</li>
							<li class="segment" id="WED-10-1730">WED-1730</li>
							<li class="segment" id="WED-10-1745">WED-1745</li>
							<li class="segment" id="WED-10-1800">WED-1800</li>
							<li class="segment" id="WED-10-1815">WED-1815</li>
							<li class="segment" id="WED-10-1830">WED-1830</li>
							<li class="segment" id="WED-10-1845">WED-1845</li>
							<li class="segment" id="WED-10-1900">WED-1900</li>
							<li class="segment" id="WED-10-1915">WED-1915</li>
							<li class="segment" id="WED-10-1930">WED-1930</li>
							<li class="segment" id="WED-10-1945">WED-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-THR-11">
							<li class = "date">THR<span>11/12/2020</span></li>
							<li class="segment" id="THR-11-1600">THR-1600</li>
							<li class="segment" id="THR-11-1615">THR-1615</li>
							<li class="segment" id="THR-11-1630">THR-1630</li>
							<li class="segment" id="THR-11-1645">THR-1645</li>
							<li class="segment" id="THR-11-1700">THR-1700</li>
							<li class="segment" id="THR-11-1715">THR-1715</li>
							<li class="segment" id="THR-11-1730">THR-1730</li>
							<li class="segment" id="THR-11-1745">THR-1745</li>
							<li class="segment" id="THR-11-1800">THR-1800</li>
							<li class="segment" id="THR-11-1815">THR-1815</li>
							<li class="segment" id="THR-11-1830">THR-1830</li>
							<li class="segment" id="THR-11-1845">THR-1845</li>
							<li class="segment" id="THR-11-1900">THR-1900</li>
							<li class="segment" id="THR-11-1915">THR-1915</li>
							<li class="segment" id="THR-11-1930">THR-1930</li>
							<li class="segment" id="THR-11-1945">THR-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-FRI-12">
							<li class = "date">FRI<span>11/13/2020</span></li>
							<li class="segment" id="FRI-12-1600">FRI-1600</li>
							<li class="segment" id="FRI-12-1615">FRI-1615</li>
							<li class="segment  window" id="FRI-12-1630">FRI-1630</li>
							<li class="segment  window" id="FRI-12-1645">FRI-1645</li>
							<li class="segment  window" id="FRI-12-1700">FRI-1700</li>
							<li class="segment  window" id="FRI-12-1715">FRI-1715</li>
							<li class="segment  window" id="FRI-12-1730">FRI-1730</li>
							<li class="segment  window" id="FRI-12-1745">FRI-1745</li>
							<li class="segment  window" id="FRI-12-1800">FRI-1800</li>
							<li class="segment  window" id="FRI-12-1815">FRI-1815</li>
							<li class="segment  window" id="FRI-12-1830">FRI-1830</li>
							<li class="segment  window" id="FRI-12-1845">FRI-1845</li>
							<li class="segment  window" id="FRI-12-1900">FRI-1900</li>
							<li class="segment  window" id="FRI-12-1915">FRI-1915</li>
							<li class="segment  window" id="FRI-12-1930">FRI-1930</li>
							<li class="segment  window" id="FRI-12-1945">FRI-1945</li>
						</ol>
						<ol class = "selectable_list" id="selectable-SAT-13">
							<li class = "date">SAT<span>11/14/2020</span></li>
							<li class="segment" id="SAT-13-1600">SAT-1600</li>
							<li class="segment" id="SAT-13-1615">SAT-1615</li>
							<li class="segment" id="SAT-13-1630">SAT-1630</li>
							<li class="segment" id="SAT-13-1645">SAT-1645</li>
							<li class="segment  window" id="SAT-13-1700">SAT-1700</li>
							<li class="segment  window" id="SAT-13-1715">SAT-1715</li>
							<li class="segment  window" id="SAT-13-1730">SAT-1730</li>
							<li class="segment  window" id="SAT-13-1745">SAT-1745</li>
							<li class="segment  window" id="SAT-13-1800">SAT-1800</li>
							<li class="segment  window" id="SAT-13-1815">SAT-1815</li>
							<li class="segment  window" id="SAT-13-1830">SAT-1830</li>
							<li class="segment  window" id="SAT-13-1845">SAT-1845</li>
							<li class="segment  window" id="SAT-13-1900">SAT-1900</li>
							<li class="segment  window" id="SAT-13-1915">SAT-1915</li>
							<li class="segment  window" id="SAT-13-1930">SAT-1930</li>
							<li class="segment  window" id="SAT-13-1945">SAT-1945</li>
						</ol>
					</div>
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
									<input id="cal_upload" class="create" type="file" aria-label="Browse" />
						</li>
						<li>
							<button class="button red span" id = "button">RSVP to Event</button>
						</li>
					</ul>
				</div>
			</div>
        </form>
  </main>

	<script type="text/javascript" src="script/rsvp_to_event.js"></script>
</body>
</html>