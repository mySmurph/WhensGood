function changeSize(){

    if(this.checked == true){
        domPasswordText.style.visibility = "visible";
        domInputPassword.style.visibility = "visible";
        
    }
    else if (this.checked != true){
        // decrease the size of the userInputBox and hide the two other elements
        domPasswordText.style.visibility = "hidden";
        domInputPassword.style.visibility = "hidden";
    }
}

function elements_visibility(){
    domPasswordText.style.visibility = "hidden";
    domInputPassword.style.visibility = "hidden";
}