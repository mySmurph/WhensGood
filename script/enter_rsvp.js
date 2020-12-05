// window.addEventListener('load',function(){
// 	var count =  Number(document.getElementById("button").value);
// 	alert(count);
// 	if(count !== 0) {
// 	window.location.replace("http://www.w3schools.com");
// 	}
// }
// );



document.getElementById("button").addEventListener("click",validateCridentials);
let domEventCode = document.getElementById("event_code");
let domBody = document.getElementById("body");
let domUserInputContainer = document.getElementById("userInputContainer");
let domPasswordText = document.getElementById("password_text");
let domInputPassword = document.getElementById("password_input");

domEventCode.setAttribute("placeholder", "2F088152DE");
domInputPassword.setAttribute("placeholder", "password");

document.getElementById('switchbox').addEventListener("change", changeSize);
var user_type = document.getElementById('switchbox');
function changeSize(){
	var password = document.getElementById("password_container");
    if(user_type.checked){
		password.style.display = "block";
    }
    else{
		password.style.display = "none";
    }
}


function validateCridentials() {
	if((domEventCode.value.length>0) && ( !user_type.checked || (domInputPassword.value.length>0) )){
		var myForm = document.getElementById("Enter_RSVP_form");
		myForm.action = "RSVP.php";
		myForm.method = "POST";
	}
	alert("Enter Event Code to Continue");
   return false;
 }