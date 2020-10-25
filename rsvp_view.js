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
