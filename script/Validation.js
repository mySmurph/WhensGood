
document.getElementById('button').addEventListener('click', ValidateForm);

//get todays date 
var today = new Date();
var todayDateString;
today.setDate(today.getDate());
todayDateString =  today.getFullYear() + '-'
                + ('0' + (today.getMonth()+1)).slice(-2) + '-'
                + ('0' + today.getDate()).slice(-2);

function ValidateForm() {
    var x = document.getElementById("event_name").value;
    if (x == '') {
        alert("Name must be filled out");
        return false;
    }

    //if statements so it doesnt read the null values as input and give unnecessary error messages
    if (!checkDates()) { return false; }
    if (!checkDeadline()) { return false; }
    if (!checkDuration()) { return false; }
    if(!checkEmail()) {return false;}
    //if(!togglePwd()) {return false;}
    
    myForm = document.getElementById("CreateEvent");
    myForm.action = "querys.php";
	myForm.method = "POST";
    return true;
}

function checkDates() {
    
  var input1 = document.getElementById("event_date_range_start").value;
  var input2 = document.getElementById("event_date_range_end").value;
  
  if(input1 == null || input1 == ""){
      alert("Start date cannot be empty");
      return false;
    }
    if(input2 == null || input2 == ""){
        alert("End date cannot be empty");
        return false;
    }
    if(input1>input2){
        alert("End date cannot be before start date");
        return false;
    }
    
    if(input1 < todayDateString){
        alert("You cannot schedule a date in the past");
        return false;
    }
    return true;
}

function checkDeadline() {
    var startDate = document.getElementById("event_date_range_start").value;
    var rsvpDate = document.getElementById("rsvp_deadline").value;

    if (rsvpDate == '' || rsvpDate == null) { alert("RSVP date must not be null"); return false;}
    if (rsvpDate > startDate) { alert("RSVP date must be before the events date range"); return false; }
    else if (rsvpDate < todayDateString) { alert("RSVP date cannot be in the past."); return false; }

    return true;
}

function checkDuration() {
    var hr = document.getElementById("hr").value;
    var min = document.getElementById("min").value;

    if (min == 0 && hr == 0) {
        alert("Must include duration of the event");
        return false;
    }
    return true;
}
function checkEmail() {
    var email = document.getElementById("organizers_email").value;
    if (email == '' || email == null) { alert("Email cannot be blank"); return false; }
    else if (!isEmail(email)) { alert("Not a valid email"); return false; }
    return true;
}
function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}


/*
function togglePwd(){
  var pass = document.getElementById("pwd");
  if (pass == '' || null ) {
    alert("Must include password");
    return false;
  } 
  return true;
}
*/