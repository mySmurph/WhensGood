function ValidateForm(){
      var x = document.getElementById("Name").value;
  if (x == '') {
    alert("Name must be filled out");
    return false;
  }
   checkDates();
    checkDeadline();
    checkDuration();

}
function checkDates(){
    var input1 = document.getElementById("startDate").value;
    var input2 = document.getElementById("endDate").value;
    
    if(input1 == null || input1 == ""){
        alert("startDate cannot be empty");
        return false;
    }
    if(input2 == null || input2 == ""){
        alert("endDate cannot be empty");
        return false;
    }
    if(input1>input2){
        alert("end date cannot be before start date");
        return false;
    }
    var today = new Date();

var date = (today.getMonth()+1)+'/'+today.getDate()+'/'+today.getFullYear() +" "+ 
today.getHours() +":"+today.getMinutes()+ " "+ today.getSeconds();

if(input1 < date){
    alert("You cannot schedule a date in the past");
    return false;
}
}

function checkDeadline(){
        var input1 = document.getElementById("startDate").value;
    var input2 = document.getElementById("endDate").value;
    var input3 = document.getElementById("RSVPDate").value;
    
    if(input3 > input2 || input3 < input1){
        alert("RSVP date is not within your event range");
        return false;
    }
    
}
function checkDuration(){
   var duration = document.getElementById("duration").value;
   if (duration == '' || duration == null){alert("duration cannot be empty"); return false;}
   if (isNaN(duration)==true){ alert("duration must be a number!"); return false;}
   if (Number.isInteger(duration) == true) {alert("duration must be a whole number");return false;}
   if(duration <= 0) {alert("duration must be greater than 0");return false;}
   
   var dat1 = document.getElementById("startDate").value;
                var date1 = new Date(dat1)//converts string to date object
                
                var dat2 = document.getElementById('endDate').value;
                var date2 = new Date(dat2)

                var oneDay = 60 * 60 * 1000; // minutes*seconds*milliseconds
                var diffDays = Math.abs((date1.getTime() - date2.getTime()) / (oneDay));
    if(duration != diffDays){alert("event duration input does not equal actual event duration");return false;}
   
    //not sure how to validate if the duration equals the difference between start and end dates
   
}
function togglePwd(){
    var x = document.getElementById("pwd");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}