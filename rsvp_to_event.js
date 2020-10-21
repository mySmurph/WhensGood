function incrementValueHold(){
    if(domEventDurationInput.value.match(/^ ?\d?\d ?HR ?\d?\d ?MIN ?$/i) && domEventDurationInput.value != ""){
        let strArray = domEventDurationInput.value.match(/\d+/g);
        hour = Number(strArray[0]);
        min = Number(strArray[1]);
    }
    else if(domEventDurationInput.value == "" && (hour != 0 || min != 0)){
        hour = 0;
        min = 0;
    }

    if(mouse_up){
        mouse_up = false;
        return;
    }
    ++min;
    if (min == 60){
        min = 0;
        ++hour;
    }
    domEventDurationInput.value = `${hour} HR ${min} MIN`;
    setTimeout(incrementValueHold, 90);
}

function stop_setTimeout(){
    mouse_up = true;
}

function decrementValueHold(){
    if(domEventDurationInput.value.match(/^ ?\d?\d ?HR ?\d?\d ?MIN ?$/i) && domEventDurationInput.value != ""){
        let strArray = domEventDurationInput.value.match(/\d+/g);
        hour = Number(strArray[0]);
        min = Number(strArray[1]);
    }
    else if(domEventDurationInput.value == "" && (hour != 0 || min != 0)){
        hour = 0;
        min = 0;
    }

    if(mouse_up){
        mouse_up = false;
        return;
    }

    if(min == 0 && hour >= 1){
        min = 59;
        --hour;
    }
    else if (min == 0 && hour == 0){
        min = 0;
    }
    else{
        --min;
    }

    domEventDurationInput.value = `${hour} HR ${min} MIN`;
    setTimeout(decrementValueHold, 90);
}

function selectDeadline(){
    if(!domRSVPDeadline.value.match(/^ ?\d?\d\/ ?\d?\d\/ ?\d{4} ?$/) && domRSVPDeadline.value != ""){
        alert("The value you entered into the RSVP text box is not valid.\nPlease enter a valid value in the same manner as: MM/DD/YYYY.");
    }
    else if(domRSVPDeadline.value == ""){
         //alert("The RSVP text box has not yet been filled in."); // use this conditional for form submittal
    }
}

function validateInput(){
    if(!domEventDurationInput.value.match(/^ ?\d?\d ?HR ?\d?\d ?MIN ?$/i) && domEventDurationInput.value != ""){
        alert("The value you entered into the Event Duration text box is not valid.\nPlease enter a valid value in the same manner as: \" 5 HR 20 MIN\".");
    }
    else if(domEventDurationInput.value.match(/^ ?\d?\d ?HR ?\d?\d ?MIN ?$/i)){
        let strArray = domEventDurationInput.value.match(/\d+/g);
        hour = Number(strArray[0]);
        min = Number(strArray[1]);
    }
    else if(domEventDurationInput.value == ""){
        // alert("The Event Duration text box has not yet been filled in.");  // use this part during form submital
    }
}
