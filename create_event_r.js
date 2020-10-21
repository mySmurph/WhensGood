let hour = 0;
let min = 0;
let mouse_up = false;
let domUpButton = document.getElementById("up_button");
let domDownButton = document.getElementById("down_button");

let domEventDurationInput = document.getElementById("event_duration_input");

// domUpButton.addEventListener("click", incrementValue, false);
// domDownButton.addEventListener("click", decrementValue, false);

domUpButton.addEventListener("mousedown", incrementValueHold, false);
domUpButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mousedown", decrementValueHold, false);