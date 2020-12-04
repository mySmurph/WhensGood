document.getElementById('button').addEventListener('click', ValidateCode);
var domEventCode = document.getElementById("event_code");

function validateEvent(){
    if(domEventCode.value==0){
        alert("no event found");
        return false;
    }
    return true;
}

function checkEventCode(){
    var domEventCode = document.getElementById('event_code');
   var result= "<?php echo validateCode(domEventCode)?>";

   if (result == 0){
       alert("that event code does not exist");
       document.querySelector("#button").addEventListener("click", function(event) {
        event.preventDefault(); }, false);
   }
}