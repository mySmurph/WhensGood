function incrementValueHold(event){
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

function selectDateRange(){

}

function selectDeadline(){
    
}