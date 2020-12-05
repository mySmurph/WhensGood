let domForm = document.getElementById("form");
let domAdminUserName = document.getElementById("username");
let domAdminPassword = document.getElementById("password");

domAdminUserName.setAttribute("placeholder", "professor enter: \"admin\"");
domAdminPassword.setAttribute("placeholder", "professor enter: \"password\"");

domForm.addEventListener("submit", validateUserNameAndPassword, false);

function validateUserNameAndPassword(){
    
    if(domAdminUserName.value == "admin" && domAdminPassword.value == "password"){
        domForm.action = "db_query.html";
        domForm.method = "post";
    }
    else{

        alert("You did not enter the correct username and password administrator access");
    }
}