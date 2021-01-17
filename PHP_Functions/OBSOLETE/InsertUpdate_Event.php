<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    include ("../PHP_Functions/functions.php");      
    $db = connectDB();            // pulled from functions.php 
    //$db = @mysqli_connect("db", "group4", "IjChbKtynlNZ", "group4");

if(!isset($_SESSION["eventFound"])){
    // Table insert for Events
    $TableName = "Events";
    $SQLstring = "SELECT * FROM $TableName;";
    $query = @mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Events(EventCode VARCHAR(16) PRIMARY KEY, 
                    EventTitle VARCHAR(55), 
                    Duration DECIMAL(3,0), 
                    Deadline DATE, 
                    EventPassword VARCHAR(16));";
        $query = @mysqli_query($db, $SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $EventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
    $EventTitle = addslashes($_POST['event_title']);
    $hr = $_POST['hr'];           // pull hr and min separately and convert them into a single digit to insert into duration
    $min = $_POST['min'];
    $Duration = (($hr*4) + ($min/15));
    $Deadline = addslashes($_POST['rsvp_deadline']);
    $EventPassword = addslashes($_POST['event_password']);
    $SQLstring = "INSERT INTO $TableName VALUES ('$EventCode', '$EventTitle', '$Duration', '$Deadline', '$EventPassword');";
    $query = @mysqli_query($db, $SQLstring)   
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";

    // Table insert for Users
    $TableName = "Users";
    $SQLstring = "SELECT * FROM $TableName;";
    $query = @mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Users (UserID VARCHAR(16) PRIMARY KEY, 
                    UserType VARCHAR(11) NOT NULL, 
                    UserName VARCHAR(55), 
                    RSVP boolean NOT NULL, 
                    Email VARCHAR(55), 
                    CalenderFile VARCHAR(96),
                    Password VARCHAR(40),
		                CONSTRAINT fk_userType FOREIGN KEY (UserType) REFERENCES User_Types(UserTypeID);";
        $query = @mysqli_query($db, $SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
	$UserID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
    $Email = addslashes($_POST['organizers_email']);

    $target_file = NULL;
    if(basename($_FILES["cal_upload"]["name"]) !=''){
        // pulling ical file, place to directory calendars/ then insert into database
        $target_dir = "calendars/";
        $target_file = $target_dir . $UserID .'_'. str_replace(' ', '', basename($_FILES["cal_upload"]["name"]));
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) { 
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["cal_upload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "ics" ) {
        echo "File type must be .ics .";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["cal_upload"]["tmp_name"], $target_file)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    }

        
    $SQLstring = "INSERT INTO $TableName VALUES ('$UserID', 'E', NULL, TRUE, '$Email', '$target_file', NULL);"; // change back to $CalendarFile
    $query = @mysqli_query($db, $SQLstring)
        Or die($SQLstring . "<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        
    // Table insert for Days
    $TableName = "Days";
    $SQLstring = "SELECT * FROM $TableName;";
    $query = mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Days(EventCode VARCHAR(16), 
                    UserID VARCHAR(16), 
                    EventDate DECIMAL(8,0), 
                    TimeArray VARCHAR(96), 
                        CONSTRAINT pk_Days PRIMARY KEY (EventCode, UserID, EventDate), 
                        CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode)  ON DELETE CASCADE, 
                        CONSTRAINT fk_userID FOREIGN KEY (UserID) REFERENCES Users(UserID)  ON DELETE CASCADE);";
        $query = @mysqli_query($db, $SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }

    $start = date('Y-m-d', strtotime($_POST['event_date_range_start'])); // to convert into YYYYMMDD
    $startdate = str_replace("-", "", $start);
    $end = date('Y-m-d', strtotime($_POST['event_date_range_end']));
    $enddate = str_replace("-", "", $end);
    $s = $startdate;            // placing into new variables to keep original dates
    $e = $enddate;
    $daysarray = array();      // where the event days sequence will go
    for($s;$s <= $e;$s++) // sets array to start on the correct day based on 
    {
        $day = date('D', strtotime($s));  // sets array to start on the correct day based on date and inserts it into array
        switch($day)                                
        {                                               // switch case to uppercase and change Thu->THR
            case "Sun":
                array_push($daysarray, "SUN");
                break;
            case "Mon":
                array_push($daysarray, "MON");
                break;
            case "Tue":
                array_push($daysarray, "TUE");
                break;
            case "Wed":
                array_push($daysarray, "WED");
                break;
            case "Thu":
                array_push($daysarray, "THR");
                break;
            case "Fri":
                array_push($daysarray, "FRI");
                break;
            default:
                array_push($daysarray, "SAT");
        }
    }
     
    $daystr = $_POST['select-result'];                 // pulling the string from event windows selections
    foreach($daysarray as $value)
    {
        $compoundstring = $daystr;
        if(strpos($compoundstring, $value) !== false)              // checks to see if the user selected any times on that day
        {
            $daypattern = "/[#]($value)(................)/";
            $timepattern = "/[-]\d+[-]/";
            $digitpattern = "/\d+/";

            preg_match_all($daypattern, $compoundstring, $days);     // parse to get selections for only one day
            $days = implode(',', $days[0]);
            preg_match_all($timepattern, $days, $times);     // parse to get the selection index 
            $times = implode(',', $times[0]);
            preg_match_all($digitpattern, $times, $digits);  // parse to get only an array without the hyphens
            
            $timebool = array();
            $index = 0;
            foreach($digits[0] as $value)                       // creates an array and inserts 1(event window) and 0 (not event window) into correct spots
            {
                for($i = $index;$i <= 95;$i++)
                {
                    if($i == $value)
                    {
                        array_push($timebool, 1);
                        $i++;
                        $index = $i;
                        break;
                    }
                    else
                    {
                        array_push($timebool, 0);
                    }
                }   
            }
            for($i;$i <= 95;$i++)                         // fill rest of array after last segment  
            {
                array_push($timebool, 0);
            }
            $timearray = implode('',$timebool);          // convert into string for timearray
            $SQLstring = "INSERT INTO $TableName VALUES('$EventCode', '$UserID', '$startdate', '$timearray');";
            $query = @mysqli_query($db, $SQLstring)
                Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $startdate = str_replace("-","", date('Y-m-d', strtotime($startdate . " +1 days")));       // to increment date by 1 day and to make sure start date does not go past end date
    if($startdate > $enddate){break;}
    }
    
    // Insert for LOGS table
    $SQLstring = "SELECT Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n') into @InsertedDays        
    FROM Days 
    CROSS JOIN
        Users using(UserID)
    WHERE 
            EventCode = '$EventCode' AND UserType = 'E';";
     $query = @mysqli_query($db, $SQLstring)
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";

    // inputs for LOGS table
    $TableName = "LOGS";
    $SQLstring = "SELECT * FROM $TableName;";
    $query = mysqli_query($db, $SQLstring);
    if(!$query){
        $SQLstring = "CREATE TABlE LOGS (LogEntry INT NOT NULL AUTO_INCREMENT, 
                    AssociatedUserID VARCHAR(16), 
                    DateTime datetime NOT NULL, 
                    Description TEXT, 
                    primary key(LogEntry));";
        $query = @mysqli_query($db, $SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $SQLstring = "INSERT INTO LOGS (AssociatedUserID, DateTime, Description) VALUES ('$UserID', NOW(), 'USER CREATED'), ('$UserID', NOW(), CONCAT('EVENT CREATED: ', '$EventCode')), ('$UserID', NOW(), CONCAT_WS('\r\n','DAYS INSERTED for EVENT:','$EventCode', @InsertedDays));";
    $query = @mysqli_query($db, $SQLstring)
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
    $SQLstring = "SET @InsertedDays = NULL;";
    $query = @mysqli_query($db, $SQLstring)
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
    }
mysqli_close($db);

$_SESSION["event_code"] = $EventCode;
$_SESSION["eventFound"] = TRUE;
header('location: ScheduleEvent.php');
    ?>