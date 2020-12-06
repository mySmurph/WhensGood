var domEventCode = document.getElementById("event_code");
var domInputPassword = document.getElementById("password_input");
var switchbox = document.getElementById('switchbox');

domEventCode.setAttribute("placeholder", "2F088152DE");
domInputPassword.setAttribute("placeholder", "password");

document.getElementById("Enter_Form_Button").addEventListener("click",validateCridentials);

function validateCridentials() {
	var isOrg = switchbox ? switchbox.checked: true;
	if((domEventCode.value.length > 0) && ( !isOrg || (domInputPassword.value.length>0) )){
		var myForm = document.getElementById("Enter_form");
		myForm.action = "hub.php";
		myForm.method = "POST";
		return true;
	}
	else{
		alert("Enter Valid Event Code to Continue '" + domEventCode.value +"'");
		return false;
	}

}