var selection =[];
$(document).ready(function() {
	$(".selectable_list" ).selectable(
	{
		
	  stop: function() {
		// clear old Selection
		$('.selected_window').each(
			function() {
				$(this).removeClass('selected_window');
			}
		);
		//get new selection
		var selection_includes_unavailible=false;
		var selection = [];
		var result = $( "#select-result" ).empty();
		$( ".ui-selected").each(
			function() {
				if(!selection_includes_unavailible){
					if(jQuery(this).hasClass('availible')){
						result.append( " #" + ( jQuery(this).attr('id')));
						selection.push(jQuery(this).attr('id'));
						$(this).addClass('selected_window');
					}
					else if (selection.length > 0){
						selection_includes_unavailible = true;
					}
					jQuery(this).removeClass('ui-selected');
				}
				jQuery(this).removeClass('ui-selected');
				
			}
		);
	  }
	}
	);
  } );

document.getElementById("button").addEventListener('click', scheduleEvent);
function scheduleEvent(){
	var windows = document.getElementsByClassName('selected_window');
	var start = document.getElementById("StartDate").innerHTML.split("-");
	var msg = "Day and Time Selected: \n";
	if (windows.length <1){
		msg += "--no time selected--";
	}else{
		var dateTimeStart = windows[0].getAttribute('id').split("-");
		var dateTimeEnd = windows[windows.length-1].getAttribute('id').split("-");
		msg += dateTimeStart[0] + " " +start[0]+"-"+(parseInt(start[1])+parseInt(dateTimeStart[1]))+"-"+start[3];
		msg += "\n";
		msg += standardTime(parseInt(dateTimeStart[2]));
		msg += " to ";
		msg += standardTime(parseInt(dateTimeEnd[2])+15);
	}
	alert(msg);
	
};
function standardTime(mtime){
	var xm = mtime>1160? "pm":"am";
	var mins = mtime%100;
	var hours = ((mtime - mins)/100)%12;
	return hours+":"+FormatNumberLength(mins, 2)+xm;
}

function FormatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}
