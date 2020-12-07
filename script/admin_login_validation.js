let domForm = document.getElementById("form");
let domAdminUserName = document.getElementById("username");
let domAdminPassword = document.getElementById("password");

domAdminUserName.setAttribute("placeholder", "\"admin\"");
domAdminPassword.setAttribute("placeholder", "\"password\"");

domForm.addEventListener("submit", validateUserNameAndPassword, false);

function validateUserNameAndPassword(){
    
    if(domAdminUserName.value.length > 0 && domAdminPassword.value.length > 0 ){
        // domForm.action = "db_query.html";
        // domForm.method = "post";
        domForm.action = "hub.php";
        domForm.method = "POST";
        return true;
    }
    else{
        alert("You did not enter the correct username and password administrator access");
    }
}