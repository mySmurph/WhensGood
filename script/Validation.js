
document.getElementById('button').addEventListener('click', ValidateForm);

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
    checkEmail();
    togglePwd();
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
    var today = new Date();
    var date = (today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate());
    //var time = (today.getHours() + ":" + today.getMinutes() + " " + today.getSeconds());
    //alert("comparing " + input1 + " vs " + date);

    if(input1 < date){
        alert("You cannot schedule a date in the past");
        return false;
    }
    return true;
}

function checkDeadline() {
    var startDate = document.getElementById("event_date_range_start").value;
    //var endDate = document.getElementById("event_date_range_end").value;
    var rsvpDate = document.getElementById("rsvp_deadline").value;

    var today = new Date();
    var date = (today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate());

    if (rsvpDate == '' || rsvpDate == null) { alert("RSVP date must not be null"); return false;}
    if (rsvpDate >= startDate) { alert("RSVP date must be before the events date range"); return false; }
    else if (rsvpDate < date) { alert("RSVP date cannot be in the past."); return false; }

    return true;
}

function checkDuration() {
    var hr = document.getElementById("hr").value;
    var min = document.getElementById("min").value;

    if (min == 0 && hr == 0) {
        alert("Must include duration of the event");
        return false;
    }
    /*
    var dat1 = document.getElementById("event_date_range_start").value;
    var date1 = new Date(dat1);//converts string to date object
                
    var dat2 = document.getElementById("event_date_range_end").value;
    var date2 = new Date(dat2);
    var oneDay =24 * 60 * 60 *1000; // hours*minutes*seconds*milliseconds
    
    var diffDays = Math.abs((date1.getTime() - date2.getTime()/ (oneDay))); 
    alert("diffDays = " + diffDays);
    if( duration != diffDays){alert("event duration input does not equal actual event duration");return false;}
   
    //not sure how to validate if the duration equals the difference between start and end dates
   */
    return true;
}
function checkEmail() {
    var email = document.getElementById("organizers_email").value;
    if (email == '' || email == null) { alert("Email cannot be blank"); return false; }
    else if (!isEmail(email)) { alert("Not a valid email"); return false; }
}
function isEmail(email) {
    return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
}
function togglePwd(){
  var x = document.getElementById("pwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}