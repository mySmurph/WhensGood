
var _class = {
	input : "input_type_text",
	invalid : "input_invalid"
};
var today = Date.now();


function validString(DOM){
	var isValid = valid_title_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}

var valid_email_format = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var valid_title_format = /^([A-Z]|[0-9]|[a-z]|[-]|[!@#$*.<>?&_ :()]){1,55}$/;
var valid_password_format = /^([A-Z]|[0-9]|[a-z]|[-]|[%!@#$*.<>?&_]){3,40}$/;
var valid_password_description = "Password must be between 3 to 40 characters and may only contain charcers that match:<br/>a-z, A-Z, 0-9, or -_!?&@#$%*.<>";
var valid_username_format = /^([A-Z]|[0-9]|[a-z]|[-]|[_]){3,30}$/;
var valid_code_format = /^([A-Z]|[0-9]|[a-z]){10}$/;
var valid_calfile_name_format = /^([A-Z]|[a-z]|[0-9]|[-]|[_ ])\w{1,60}\.ics$/;
var valid_username_decription = "Usernames must be between 3 to 30 characters ans may only contain charcers that match:<br/>a-z, A-Z, 0-9, or -_";

function validUsername(DOM){
	var isValid = valid_username_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}

function validCalendar(DOM){
	var isValid = valid_calfile_name_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}

function validPassword(DOM){
	var isValid = valid_password_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}
function validEmail(DOM) {
	var isValid = valid_email_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}
function validCode(DOM) {
	var isValid = valid_code_format.test(DOM.value);
	showError(isValid, DOM);
	return isValid;
}
var selection = [];
function validSelection(){
	var collection = Array.from(document.getElementsByClassName("ui-selected"));
	selection = [];
	var important_info = /(^\d{1})|(\d{3}$)/g; // id = "2_2020-12-29_027", match == ["2", "027"]
	collection.forEach(elem =>{
		selection.push((elem.id).match(important_info));
	});

	var isValid = (selection.length > 0 ) || !validatorclicked;

	showError(isValid, DOM_cal);

	return isValid;
}
function validDates() {
	var date_start = Date.parse(DOM_date_start.value);
	var date_end = Date.parse(DOM_date_end.value);
	var date_rsvp = Date.parse(DOM_date_rsvp.value);
	
	// if(all dates are dates){if(dates are in order){true}}else{false}
	var isValid = !(isNaN(date_start)|| isNaN(date_end) || isNaN(date_rsvp)) ? (date_rsvp >= today && date_start >= date_rsvp && date_end >= date_start) : false;

	showError(isValid, DOM_date_start);
	showError(isValid, DOM_date_end);
	showError(isValid, DOM_date_rsvp);
	// console.log(
	// 	"start:"+date_start+"\n"+
	// 	"end:"+date_end+"\n"+
	// 	"rsvp:"+date_rsvp+"\n"
	// )
	console.log("dates = " + isValid);
    return isValid;
}

function validDuration() {
    var hr = parseInt(DOM_hr.value);
    var min = parseInt(DOM_min.value);

	var validHR = !isNaN(hr)? hr >= 0 && hr < 24 : false;
	var validMIN = !isNaN(min)? min >= 0 && min < 60 : false;

	var isValid = (validHR && validMIN) ? !(hr == 0 && min == 0) : false;
	
	showError(isValid, DOM_hr);
	// console.log("duration => " +hr+":"+min + "=>"+isValid);
    return isValid;
}
function alert(type, message){
	type = type ? 'good' : 'bad';
	var alert_popup =	"<div class=\"alert " + type + "\">";
	alert_popup +=	"<span class=\"closebtn\" onclick=\"this.parentElement.style.display='none';\">&times;</span>";
	alert_popup +=	"<strong>"+message+"</strong>";
	alert_popup +=	"</div>";
	return alert_popup;

}

function showError(isOK, elem){
	if(isOK){
		removeClass(_class.invalid, elem);
	}else{
		addClass(_class.invalid, elem);
	}
}

function addClass(c, elem){
	console.log("addClass("+elem.id+")");
	var parent = elem.closest("."+_class.input);
	parent = parent == null ? elem : parent;
	if(parent != null && !parent.classList.contains(c)){
		parent.classList.add(c);
	}
}
function removeClass(c, elem){
	console.log("removeClass("+elem.id+")");
	var parent = elem.closest("."+_class.input);
	parent = parent == null ? elem : parent;
	if(parent.classList.contains(c)){
		parent.classList.remove(c);
	}
}

function active_checkDate(date_input){
	var date = Date.parse(date_input.value);
	var isValid = !isNaN(date);
	if(isValid){
		isValid = isRationalDate(date_input);
	}
	showError(isValid, date_input);
	return isValid;
}
function isRationalDate(date_input){
	var date = Date.parse(date_input.value);

	var isRational = false;
	
	var isDeclared_start = DOM_date_start.value != '';
	var isDeclared_end = DOM_date_end.value != '';
	var isDeclared_rsvp = DOM_date_rsvp.value != '';
	// console.log(
	// 	"start:"+isDeclared_start+"\n"+
	// 	"end:"+isDeclared_end+"\n"+
	// 	"rsvp:"+isDeclared_rsvp+"\n"
	// )
	
	if(date >= today){

		if(date_input == DOM_date_start){
			isRational = isDeclared_end? Date.parse(DOM_date_end.value) > date: true;
			if(isDeclared_rsvp){
				var alsoOK = Date.parse(DOM_date_rsvp.value) >= date;
				showError(alsoOK, DOM_date_rsvp);
			}
			// console.log("input.start  ==> " + isRational);
		}
		else if(date_input == DOM_date_end){
			isRational = isDeclared_start ? date > Date.parse(DOM_date_start.value): true;
			// console.log("input.end  ==> " + isRational);
		}
		else{
			isRational = isDeclared_start ? Date.parse(DOM_date_start.value) >= date : true;
			// console.log("input.rsvp  ==> " + isRational);
		}
	}
	return isRational;
}

// compare arrays

// // Warn if overriding existing method
// if(Array.prototype.equals)
//     console.warn("Overriding existing Array.prototype.equals. Possible causes: New API defines the method, there's a framework conflict or you've got double inclusions in your code.");
// attach the .equals method to Array's prototype to call it on any array
Array.prototype.equals = function (array) {
    // if the other array is a falsy value, return
    if (!array)
        return false;

    // compare lengths - can save a lot of time 
    if (this.length != array.length)
        return false;

    for (var i = 0, l=this.length; i < l; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].equals(array[i]))
                return false;       
        }           
        else if (this[i] != array[i]) { 
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;   
        }           
    }       
    return true;
}
// // Hide method from for-in loops
// Object.defineProperty(Array.prototype, "equals", {enumerable: false});