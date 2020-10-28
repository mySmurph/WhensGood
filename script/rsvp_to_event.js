
var domChooseFile = document.getElementById("choose_file");
var domName = document.getElementById("name");
var domEmail = document.getElementById("email");
var domSlider = document.getElementById("switchbox");
document.getElementById("button").addEventListener('click', submitRSVP);

domChooseFile.setAttribute("placeholder", "Choose File...");
domName.setAttribute("placeholder", "Zapp Brannigan");
domEmail.setAttribute("placeholder", "example@email.domain"); 

document.getElementById("cal_upload").addEventListener("change", setFile);

function submitRSVP(){

		alert(filledzOutForm()?"Thank you for RSVPing!":"Your RSVP could not be processed");

}
function filledzOutForm(){
	return hasName() && (!hasAccepted() || (hasFile() && hasEmail()) );
}
function hasName(){
	return domName.value.length>0;
}
function hasEmail(){
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(domEmail.value);
}
function hasAccepted(){
	return domSlider.checked;
}

function setFile(){
	domChooseFile.setAttribute("placeholder", document.getElementById("cal_upload").value);
}
function hasFile(){
	return document.getElementById("cal_upload").value.length>0;
}
$(".hour_table").ready(function() {
	$(".selectable_list" ).selectable(
	{
		
	  stop: function() {
		// clear Selection
		$( ".ui-selected").each(
			function() {
				jQuery(this).removeClass('ui-selected');
			}
		);
	  }
	}
	);
  } );