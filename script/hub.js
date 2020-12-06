var domEventCode = document.getElementById("event_code");
var domInputPassword = document.getElementById("password_input");
var switchbox = document.getElementById('switchbox');
if(switchbox !=null){
	switchbox.addEventListener("change", changeSize);
}


domEventCode.setAttribute("placeholder", "2F088152DE");
domInputPassword.setAttribute("placeholder", "password");

// place working event code and password
// domEventCode.value = "1kxEQfw3ce" ;
// domInputPassword.value = "MyFakePassword";

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

function changeSize(){
	var password = document.getElementById("password_container");
    if(switchbox.checked){
		password.style.display = "block";
    }
    else{
		password.style.display = "none";
    }
}
