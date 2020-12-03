<?php
$target_dir = "calendars/";
$userID = $_POST['userID'];
$target_file = $target_dir . $userID .'_'. str_replace(' ', '', basename($_FILES["cal_upload"]["name"]));
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
    header("Location: index.php"); 

  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>