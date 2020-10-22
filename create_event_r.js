let hour = 0;
let min = 0;
let mouse_up = false;
let domUpButton = document.getElementById("up_button");
let domDownButton = document.getElementById("down_button");

let domEventDurationInput = document.getElementById("event_duration_input");
let domRSVPDeadline = document.getElementById("rsvp_deadline");
let domEventDateRange = document.getElementById("event_date_range");

domUpButton.addEventListener("mousedown", incrementValueHold, false);
domUpButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mousedown", decrementValueHold, false);

domEventDurationInput.addEventListener("change", validateInput, false);
domEventDateRange.addEventListener("change", validateDateRange, false);

// domEventDateRange.addEventListener("click", selectDateRange, false);
domRSVPDeadline.addEventListener("click", selectDeadline, false);

