
var domChooseFile = document.getElementById("choose_file");
var domName = document.getElementById("name");
var domEmail = document.getElementById("email");
var domSlider = document.getElementById("switchbox");
document.getElementById("button").addEventListener('click', submitRSVP);

domChooseFile.setAttribute("placeholder", "Choose File...");
domName.setAttribute("placeholder", "Zapp Brannigan");
domEmail.setAttribute("placeholder", "example@email.domain"); 



function submitRSVP(){
	alert(document.getElementById("cal_upload").value);
}
function hasName(){
	return domName.value>0;
}
function hasEmail(){
	return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(domEmail.value);
}
function hasAccepted(){
	return domSlider.checked;
}
// $(".hour_table").ready(function() {
// 	$(".selectable_list" ).selectable(
// 	{
		
// 	  stop: function() {
// 		// clear Selection
// 		$( ".ui-selected").each(
// 			function() {
// 				jQuery(this).removeClass('ui-selected');
// 			}
// 		);
// 	  }
// 	}
// 	);
//   } );