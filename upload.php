<?php
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
include ("functions.php");
$target_dir = "calendars/";
$userID = $_POST['userID'];
$target_file = $target_dir . $userID .'_'. str_replace(' ' ,  '' ,  basename($_FILES["cal_upload"]["name"]));
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file , PATHINFO_EXTENSION));


// // Check if file already exists
// if (file_exists($target_file)) { 
//  echo "Sorry ,  file already exists.";
//  $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["cal_upload"]["size"] > 500000) {
//  echo "Sorry ,  your file is too large.";
//  $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "ics" ) {
//  echo "File type must be .ics .";
//  $uploadOk = 0;
// }

// // Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
 echo "Sorry ,  your file was not uploaded.";
// if everything is ok ,  try to upload file
} else {
 if (move_uploaded_file($_FILES["cal_upload"]["tmp_name"] ,  $target_file)) {
  header("Location: index.php"); 

 } else {
  echo "Sorry ,  there was an error uploading your file.";
 }
}
$db = connectDB(); 


$INSERT = @mysqli_query($db ,  "SET @EventCode = '". $_SESSION['event_code'] . "';");
$INSERT = @mysqli_query($db ,  "SET @UserID = '".$userID."';");
$INSERT = @mysqli_query($db ,  "SET @NAME = '".$_POST['name']."';");
$INSERT = @mysqli_query($db ,  "SET @EMAIL = '".addslashes(htmlspecialchars($_POST['email']))."';");
$INSERT = @mysqli_query($db ,  "SET @CAL = ".$target_file.";");
$INSERT = @mysqli_query($db ,  "SET @InsertedDays = NULL;");
$INSERT = @mysqli_query($db ,  "insert into Users( UserID ,  UserType ,  UserName ,  RSVP ,  Email ,  CalenderFile ) Values( @UserID ,  'P' ,  @NAME ,  True ,  @EMAIL ,  @CAL );");
$INSERT = @mysqli_query($db ,  "insert into Days( EventCode ,  UserID ,  EventDate ,  TimeArray ) Values ( @EventCode ,  @UserID , '00000000' , NULL);");
$INSERT = @mysqli_query($db ,  "Select Group_CONCAT(CONCAT(EventDate , ': ' ,  IFNULL(TimeArray ,  'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where EventCode = @EventCode AND UserID = @UserID;");
$INSERT = @mysqli_query($db ,  "insert into LOGS( AssociatedUserID ,  DateTime ,  Description)  VALUES  ( @UserID ,   NOW() ,  'USER CREATED') ,   ( @UserID ,   NOW() ,  CONCAT_WS('\r\n' , 'DAYS INSERTED for EVENT:' , @EventCode ,  @InsertedDays));");
$INSERT = @mysqli_query($db ,  "SET @EventCode = NULL;");
$INSERT = @mysqli_query($db ,  "SET @UserID = NULL;");
$INSERT = @mysqli_query($db ,  "SET @NAME = NULL';");
$INSERT = @mysqli_query($db ,  "SET @EMAIL = NULL;");
$INSERT = @mysqli_query($db ,  "SET @CAL = NULL;");
$INSERT = @mysqli_query($db ,  "SET @InsertedDays = NULL;");

// "SET @UserID = '".$userID."'; SET @NAME = '".$_POST['name']."'; SET @EMAIL = '".addslashes(htmlspecialchars($_POST['email']))."'; SET @CAL = '".addslashes(htmlspecialchars($_FILES['cal_upload']['name']))."'; SET @InsertedDays = NULL; insert into Users( UserID ,  UserType ,  UserName ,  RSVP ,  Email ,  CalenderFile ) Values( @UserID ,  'P' ,  @NAME ,  True ,  @EMAIL ,  @CAL ); insert into Days( EventCode ,  UserID ,  EventDate ,  TimeArray ) Values ( @EventCode ,  @UserID , '00000000' , NULL);  Select Group_CONCAT(CONCAT(EventDate , ': ' ,  IFNULL(TimeArray ,  'NULL')) SEPARATOR '\r\n') into @InsertedDays From Days Where EventCode = @EventCode AND UserID = @UserID;  insert into LOGS( AssociatedUserID ,  DateTime ,  Description)  VALUES  ( @UserID ,   NOW() ,  'USER CREATED') ,   ( @UserID ,   NOW() ,  CONCAT_WS('\r\n' , 'DAYS INSERTED for EVENT:' , @EventCode ,  @InsertedDays));  SET @EventCode = NULL;  SET @UserID = NULL;  SET @InsertedDays = NULL;";

// // echo $sql;
// $INSERT = @mysqli_query($db ,  $sql) Or die(mysqli_error($db));
mysqli_close($db);
header("Location: index.php");
?>