let domEventCode = document.getElementById("event_code");
let domBody = document.getElementById("body");
let domUserInputContainer = document.getElementById("userInputContainer");
let domPasswordText = document.getElementById("password_text");
let domInputPassword = document.getElementById("password_input");
let domSlider = document.getElementById("slider");

domEventCode.setAttribute("placeholder", "2F088152DE");
domInputPassword.setAttribute("placeholder", "password");

document.getElementById('slider').addEventListener("change", changeSize);
var user_type = document.getElementById('slider');
function changeSize(){
	var password = document.getElementById("password_container");
    if(user_type.checked){
		password.style.display = "block";
    }
    else{
		password.style.display = "none";
    }
}
