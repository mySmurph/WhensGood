let hour = 0;
let min = 0;
let mouse_up = false;
let domUpButton = document.getElementById("up_button");
let domDownButton = document.getElementById("down_button");

let domEventDurationInput = document.getElementById("event_duration_input");
let domEventDateRange = document.getElementById("event_date_range_calender");
let domRSVPDeadline = document.getElementById("deadline_calender");

domUpButton.addEventListener("mousedown", incrementValueHold, false);
domUpButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mouseup", stop_setTimeout, false);
domDownButton.addEventListener("mousedown", decrementValueHold, false);

domEventDateRange.addEventListener("click", selectDateRange, false);
domRSVPDeadline.addEventListener("click", selectDeadline, false);