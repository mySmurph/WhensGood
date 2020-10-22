let domBody = document.getElementById("body");
let domUserInputContainer = document.getElementById("userInputContainer");
let domPasswordText = document.getElementById("password_text");
let domInputPassword = document.getElementById("password_input");
let domSlider = document.getElementById("slider");

domSlider.addEventListener("click", changeSize, false);
domBody.addEventListener("load", elements_visibility, false);