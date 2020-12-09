<?php  
include ("functions.php");

//global varibles for debugging
$code = '1kxeqfw3ce';           //temp event code thats loaded
$userID = 'e8l7whwrtb';            //benders ID who said yes
$userID2 = 'e8l8gk1cms';        //Kifs ID who said no
$code1 = '';

//open connection to the database
$conn = @mysqli_connect("localhost", "group4", "IjChbKtynlNZ") 
    Or die("<p>Unable to connect to the database server.</p>" 
    . "<p>Error code " . mysqli_connect_errno() 
    . ": " . mysqli_connect_error()) . "</p>";

//check if the database can be reached
$db = "group4";
@mysqli_select_db($conn, $db) 
    Or die("<p>Unable to select the database.</p>" . "<p>Error code" .
    mysqli_errno($db) . ": " . mysqli_error($db)) . "</p>";

//pull the event days and time arrays
//$window =  getDateRange($code);
//echo "<pre>",print_r($window),"</pre>";
$window = array("20201116","20201120");

//create and empty day array
function createDayArray(){
    $dayAr = array(TRUE);
    for ($i=0; $i < 96; $i++) {
        array_push($dayAr, TRUE);
    }
    return $dayAr;
}

//used to find the array key assoc with time IE 24:00 == index 96
function findArrayKey($arKey){
     $keysAr = array("0000" => "1","0015" => "2","0045" => "3","0100" => "4",
                "0115" => "5","0130" => "6","0145" => "7","0200" => "8",
                "0215" => "9","0230" => "10","0245" => "11","0300" => "12",
                "0315" => "13","0330" => "14","0345" => "15","0400" => "16",
                "0415" => "17","0430" => "18","0445" => "19","0500" => "20",
                "0515" => "21","0530" => "22","0545" => "23","0600" => "24",
                "0615" => "25","0630" => "26","0645" => "27","0700" => "28",
                "0715" => "29","0730" => "30","0745" => "31","0800" => "32",
                "0815" => "33","0830" => "34","0845" => "35","0900" => "36",
                "0915" => "37","0930" => "38","0945" => "39","1000" => "40",
                "1015" => "41","1030" => "42","1045" => "43","1100" => "44",
                "1115" => "45","1130" => "46","1145" => "47","1200" => "48",
                "1215" => "49","1230" => "50","1245" => "51","1300" => "52",
                "1315" => "53","1330" => "54","1345" => "55","1400" => "56",
                "1415" => "57","1430" => "58","1445" => "59","1500" => "60",
                "1515" => "61","1530" => "62","1545" => "63","1600" => "64",
                "1615" => "65","1630" => "66","1645" => "67","1700" => "68",
                "1715" => "69","1730" => "70","1745" => "71","1800" => "72",
                "1815" => "73","1830" => "74","1845" => "75","1900" => "76",
                "1915" => "77","1930" => "78","1945" => "79","2000" => "80",
                "2015" => "81","2030" => "82","2045" => "83","2100" => "84",
                "2115" => "85","2130" => "86","2145" => "87","2200" => "88",
                "2215" => "89","2230" => "90","2245" => "91","2300" => "92",
                "2315" => "93","2330" => "94","2345" => "95","2400" => "96"
               );
   return $keysAr[$arKey];
}

//used to set grab various time information out of the the string
function setDayInfo($value1,&$year,&$month,&$date,&$time){
    $dt = $value1; 
    $year = substr($dt,0,4); 
    $month = substr($dt,4,2);        
    $date = substr($dt,6,2);
    $time = substr($dt,9,4);
}

// the initial parse of the iCal file that makes a multi d assoc array
function iCalParse($file) {
        
        //opens file as string
        $ical = file_get_contents($file);

        //initial parse, storing matches in $result
        preg_match_all('/(BEGIN:VEVENT.*?END:VEVENT)/si', $ical, $result, PREG_PATTERN_ORDER);

        for ($i = 0; $i < count($result[0]); $i++) {

            //second parse into sub array of strings
            $tmpbyline = explode("\r\n", $result[0][$i]);

            //use foreach to go through each sub array where $item 
            foreach ($tmpbyline as $item) {

                //explode useing : as delimeter so
                $tmpholderarray = explode(":",$item);
                if (count($tmpholderarray) >1) {
                    $majorarray[$tmpholderarray[0]] = $tmpholderarray[1];
                }
            }

            //conneting all the description values
            if (preg_match('/DESCRIPTION:(.*)END:VEVENT/si', $result[0][$i], $regs)) {
                $majorarray['DESCRIPTION'] = str_replace("  ", " ", str_replace("\r\n", "", $regs[1]));
            }

            //passes the main array and deletes the holder
            $icalarray[] = $majorarray;
            unset($majorarray);
            }
    return $icalarray;
}

//used to grab min and hours from string
function getHrsMin($time,&$h,&$m){
    $h = substr($time,0,2);
    $m = substr($time,2,2);
}

//used to convert the passed iCal string time into local time
function convertUTC(&$time, &$date){
    $h = substr($time,0,2);
    $m = substr($time,2,2);
    if ($h >= "08"){
        $h= $h - "08";
        $time = $h . $m;
        $time = str_pad($time, 4, '0', STR_PAD_LEFT); //insure it leads with 0's for format
    } else {
        //the case where converting UTC takes you into yesterday
        $otherSide = "08"- $h;
        $h = "24" - $otherSide;
        $time = $h . $m;
        $date = $date - "01";
        $date = str_pad($date, 2, '0', STR_PAD_LEFT);                            
    }
}
/*******************************************************************
un pack the file
*******************************************************************/

//read events
$events = iCalParse("nrkieffer@gmail.com.ics"); 
$day = createDayArray();                        
$dayArrayAll = array();
$counter = 0;                                   //for total array

//go through each sub array to find times
foreach ($events as $key => $value) {           //removed print_r here
    foreach ($value as $key1 => $value1) {

        //ignore strings that are not in the right format, should be 16 ch
        //ignore the wrong year and past events
        $flag = $flag2 = $flag3 = FALSE;
        $dateStr = strlen($value1);
        $yearCheck = substr($value1,0,4);
        $monthCheck = substr($value1,4,2);
        $currMonth =date('m',time()); 
        if(($dateStr == 16||$dateStr == 15) && $yearCheck == "2020"){$flag=TRUE;}
        if($monthCheck == $currMonth){$flag2 = TRUE;}
        if($flag==TRUE && $flag2){

            //grab the times of events
            if ($key1=='DTSTART'||$key1=='DTSTART;TZID=America/Los_Angeles'){
                setDayInfo($value1,$year,$month,$date,$time);
            }
            if ($key1=='DTEND'||$key1=='DTEND;TZID=America/Los_Angeles'){
                setDayInfo($value1,$year2,$month2,$date2,$time2);

                //check if UTC or PST
                $checkUTC = strlen($key1);
                if ($checkUTC < 8){
                    //convert from UTC to PST
                    convertUTC($time,$date);
                    convertUTC($time2,$date2);
                }
                if ($checkUTC < 8){
                    //time span
                    getHrsMin($time,$h,$m);
                    getHrsMin($time2,$h2,$m2);
                }

                //----set the day array----
                $arrStart=findArrayKey($time);
                
                //handle time span less than a hour 
                $hrsCheck = $time2 - $time;
                if($hrsCheck < "100"){
                    $min = $m2 - $m;
                    $min = (int)$min;
                    $min = abs($min);
                    $minDiv = $min/15;
  
                    //add min to day array 
                    for ($d=0; $d < $minDiv; $d++) { 
                        $day[$arrStart] = FALSE;
                        $arrStart = $arrStart + "1";
                    }
                }else{
                    //greater than a hour time span
                    $hrs = $h2 - $h;
                    $min = $m2 - $m;
                    $min = (int)$min;
                    $min = abs($min);
                    $minDiv = $min/15;
                    $minDiv = $min/"15";                    //for loop to add at end    
                    if($hrs > 0){
                        for ($i=0; $i < $hrs; $i++) {       //nested loop sets False everywhere their scheduled       
                            for ($x=0; $x < 4; $x++) {
                                $day[$arrStart] = FALSE;
                                $arrStart = $arrStart + "1";
                            }
                        }
                        //skip add min to array if there is none
                        if($min > 0){
                            for ($b=0; $b < $minDiv; $b++) {     //also sets false same reason but for minutes
                                $day[$arrStart] = FALSE;
                                $arrStart = $arrStart + "1";
                            }
                        }
                    }
                    //if the time span is less than a hr
                }
            
                //is date already in master array?
                if((array_key_exists($year.$month.$date, $dayArrayAll))){
                    //pull out the sub array
                    $box = $dayArrayAll[$year.$month.$date]; 

                    //combine them current dayArr with old one
                    for ($i=0; $i < 96; $i++) { 
                      if($day[$i]==FALSE){
                        $box[$i] = $day[$i];
                      }
                    }
                    //save new combination at date
                    $dayArrayAll[$year.$month.$date] = $box;
                    
                }else{
                //add new day into larger array
                $dayArrayAll[$year.$month.$date] = $day;
                $day = createDayArray();          //empty the holder
                
                } 
            }  
        }         
    }       
}
echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!END OFF LOOP!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
echo "<pre>",print_r($dayArrayAll),"</pre>";


