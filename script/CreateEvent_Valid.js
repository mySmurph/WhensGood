document.getElementById('button').addEventListener('click', validForm);
var myForm = document.getElementById("form_CreateEvent");

var DOM_event_title 	= document.getElementById("event_title");
var DOM_hr 				= document.getElementById("hr");
var DOM_min 			= document.getElementById("min");
// var DOM_email 			= document.getElementById("organizers_email");
// var DOM_password 		= document.getElementById("event_password");

var DOM_date_start 		= document.getElementById("event_date_range_start");
var DOM_date_end		= document.getElementById("event_date_range_end");
var DOM_date_rsvp 		= document.getElementById("rsvp_deadline");
var DOM_edit			= document.getElementById("isEdit");

// var DOM_selections 		= document.getElementById("select-result");
var DOM_cal = document.getElementsByClassName("selectable_calendar_object_container")[0];

DOM_date_start.addEventListener("change", function(){active_checkDate(this);});
DOM_date_end.addEventListener("change", function(){active_checkDate(this);});
DOM_date_rsvp.addEventListener("change", function(){active_checkDate(this);});
// DOM_email.addEventListener("change", function(){validEmail(this);});
DOM_cal.addEventListener("mouseleave", function(){validSelection();});
DOM_event_title.addEventListener("change", function(){validString(this);});
DOM_hr.addEventListener("change", function(){validDuration();});
DOM_min.addEventListener("change", function(){validDuration();});


var validatorclicked = false;
function validForm() {
	//dump stored selection
	validatorclicked = true;

	var checks = DOM_edit.checked ? [
		validString(DOM_event_title),
		validSelection(),
		validDuration()	
	]:
	[
		validString(DOM_event_title),
		validSelection(),
		validDuration(),
		validDates()
	];

	var isValid = true;
	console.log(checks);
	checks.forEach(check => {
		isValid = isValid && check;
	}); 
	console.log("validForm: "+isValid);
	if(isValid){
		var select_string = '';
		selection.forEach(s => {
			select_string += "#" + s[0] + ":" + s[1];

		});
		document.getElementById("window_selection").value = select_string;

		myForm.action = "../WhensDay/processing_user_transaction.php";
		myForm.method = "POST";
		myForm.submit();
	}
	return isValid;

}

