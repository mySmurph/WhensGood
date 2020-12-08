
<?php
    include ("functions.php");
    $db = connectDB();

    // Table insert for Events
    $TableName = "Events";
    $SQLstring = "SELECT * FROM $TableName";
    $query = mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Events (EventCode VARCHAR(16) PRIMARY KEY, 
                    EventTitle VARCHAR(55), 
                    Duration DECIMAL(3,0), 
                    Deadline DATE, 
                    EventPassword VARCHAR (16))";
        $query = @mysqli_query($SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $EventCode = base_convert((strval(time()) . sprintf('%05d',rand (0, 99999))), 10, 36);
    $EventTitle = addslashes($_POST['event_name']);
    $hr = $_POST['hr'];  // to return hr and min as a single integer 
    $min = $_POST['min'];
    $Duration = (($hr*4) + ($min/15));
    $Deadline = addslashes($_POST['rsvp_deadline']);
    $EventPassword = addslashes($_POST['event_password']);
    $SQLstring = "INSERT INTO $TableName VALUES($EventCode, $EventTitle, $Duration, $Deadline, $EventPassword)";
    $query = @mysqli_query($db, $SQLstring)   
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
    
    // Table insert for Users
    $TableName = "Users";
    $SQLstring = "SELECT * FROM $TableName";
    $query = @mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Users (UserID VARCHAR(16) PRIMARY KEY, 
                    UserType VARCHAR(11) NOT NULL, 
                    UserName VARCHAR(55), 
                    RSVP boolean NOT NULL, 
                    Email VARCHAR(55), 
                    CalenderFile VARCHAR(96)";
        $query = @mysqli_query($SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
	$UserID = base_convert((strval(intval(time())-159999999) . sprintf('%03d',rand (0, 999)) . sprintf('%03d',rand (0, 999))) , 10, 36);
    $Email = addslashes($_POST['organizers_email']);
    $CalendarFile = addslashes($_POST['choose_file']);
    $SQLstring = "INSERT INTO $TableName VALUES($UserID, 'E', NULL, True, $Email, $CalendarFile)";
    $query = @mysqli_query($db, $SQLstring)
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
    
    // Table insert for Days
    $TableName = "Days";
    $SQLstring = "SELECT * FROM $TableName";
    $query = mysqli_query($db, $SQLstring); //checking if table is created 
    if(!$query){
        $SQLstring = "CREATE TABLE Days(EventCode VARCHAR(16), 
                    UserID VARCHAR(16), 
                    EventDate DECIMAL(8,0), 
                    TimeArray VARCHAR(96), 
                        CONSTRAINT pk_Days PRIMARY KEY (EventCode, UserID, EventDate), 
                        CONSTRAINT fk_event_code FOREIGN KEY (EventCode) REFERENCES Events(EventCode)  ON DELETE CASCADE, 
                        CONSTRAINT fk_userID FOREIGN KEY (UserID) REFERENCES Users(UserID)  ON DELETE CASCADE)";
        $query = @mysqli_query($SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }

    $start = date('Y-m-d', strtotime($_POST['event_date_range_start'])); // to convert into YYYYMMDD
    $startdate = str_replace("-", "", $start);
    $end = date('Y-m-d', strtotime($_POST['event_date_range_end']));
    $enddate = str_replace("-", "", $end);
    
    $s = $startdate;            // placing into new variables to keep original dates
    $e = $enddate;
    $daysarray = array();      // where the start day sequence will go
    for($s;$s <= $e;$s++) // sets array to correct start day based on date
    {
        $day = date('D', strtotime($s));  // switch case for uppercase and to change Thu->THR
        switch($days)
        {
            case "Sun":
                array_push($daysarray, 'SUN');
                break;
            case "Mon":
                array_push($daysarray, 'MON');
                break;
            case "Tue":
                array_push($daysarray, 'TUE');
                break;
            case "Wed":
                array_push($daysarray, 'WED');
                break;
            case "Thu":
                array_push($daysarray, 'THR');
                break;
            case "Fri":
                array_push($daysarray, 'FRI');
                break;
            default:
                array_push($daysarray, 'SAT');
        }
    }
    $daystr = $_POST['select-result'];                 // pulling the string from event windows selections
    foreach($daysarray as $value)
    {
        $compoundstring = $daystr;
        if(strpos($compoundstring, $value) !== false)              // checks to see if the user selected any times on that day
        {
            $daypattern = "/[#]($daysarray)(................)/";
            $timepattern = "/[-]\d+[-]/";
            $digitpattern = "/\d/";

            preg_match_all($daypattern, $compoundstring, $days);     // parse to get selections for only one day
            $days = implode(',', $days[0]);
            preg_match_all($timepattern, $days, $times);     // parse to get the selection index
            $times = implode(',', $times[0]);
            preg_match_all($digitpattern, $times, $digits);  // parse to get only an array with indexes

            $timebool = array();
            $index = 0;
            foreach($digits as $value)                       // creates an array and inserts 0 and 1 into correct spots
            {
                for($i = $index;$i <= 95;$i)
                {
                    if($i == $value)
                    {
                        array_push($b, 1);
                        $i++;
                        $index = $i;
                        break;
                    }
                    else
                    {
                        array_push($b, 0);
                    }
                }   
            }
            for($index;$index <= 95;$index++)                         // fill rest of array after last segment 
            {
                array_push($b, 0);
            }

            $timearray = implode('',$timebool);          // convert into string 
            $SQLstring = "INSERT INTO $TableName VALUES($eventCode, $userID, $startdate, $timearray)";
            $query = @mysqli_query($db, $SQLstring)
                Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $startdate += 1;
    if($startdate > $enddate){break;}
    }
    
    $InsertedDays = NULL;
    $SQLstring = "Select Group_CONCAT(CONCAT(EventDate,': ',  IFNULL(TimeArray, 'NULL')) SEPARATOR '\r\n')
        into $InsertedDays
        From Days
        Cross Join
            Users using(UserID)
        Where 
                EventCode = $EventCode
            AND	UserType = 'E';";
    $query = @mysqli_query($db, $SQLstring)
        Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";

    // inputs for LOGS table
    $TableName = LOGS;
    $SQLstring = "SELECT * FROM $TableName";
    $query = mysqli_query($db, $SQLstring);
    if(!$query){
        $SQLstring = "CREATE TABlE LOGS (LogEntry INT NOT NULL AUTO_INCREMENT, 
                    AssociatedUserID VARCHAR(16), 
                    DateTime datetime NOT NULL, 
                    Description TEXT, 
                    primary key(LogEntry))";
        $query = @mysqli_query($SQLstring)
            Or die("<p> Unable to Execute. </p>" . "<p> Error code " . mysqli_errno($db) .": " . mysqli_error($db)) . "</p>";
        }
    $query = "INSERT INTO $TableName VALUES ($UserID, NOW(), 'USER CREATED'), ($UserID, NOW(), CONCAT('EVENT CREATED: ', $EventCode)), ($UserID, NOW(), CONCAT_WS('\r\n','DAYS INSERTED for EVENT:',$EventCode, $InsertedDays))";
    $InsertedDays = NULL;
    mysqli_close($db);
    ?>