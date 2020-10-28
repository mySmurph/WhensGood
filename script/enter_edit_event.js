document.getElementById("button").addEventListener("click",validateCridentials);
var domEventCode = document.getElementById("event_code");
var domInputPassword = document.getElementById("password_input");

domEventCode.setAttribute("placeholder", "2F088152DE");
domInputPassword.setAttribute("placeholder", "password");

function validateCridentials(){
	if(domInputPassword.value==0 || domEventCode.value==0){
		alert("no event found");
		return false;
	}
	return true;
}