
let domChooseFile = document.getElementById("choose_file");
let domName = document.getElementById("name");
let domEmail = document.getElementById("email");

domChooseFile.setAttribute("placeholder", "Choose File...");
domName.setAttribute("placeholder", "Zapp Brannigan");
domEmail.setAttribute("placeholder", "example@email.domain"); 

domSlider.addEventListener("click", changeSize, false);
domBody.addEventListener("load", elements_visibility, false);