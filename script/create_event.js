let domEventName = document.getElementById("event_name");
let domOrgEmail = document.getElementById("organizers_email");
let domEventPassword = document.getElementById("event_password");
let domChooseFile = document.getElementById("choose_file");

domEventName.setAttribute("placeholder", "Event Name");
domOrgEmail.setAttribute("placeholder", "example@email.domain");
domEventPassword.setAttribute("placeholder", "password");
domChooseFile.setAttribute("placeholder", "Choose File...");


$(document).ready(function() {
	$(".selectable_list").selectable(
	{
	  selected: function() {
		var result = $( "#select-result" ).empty();
		$( ".ui-selected").each(function() {
		  if(jQuery(this).hasClass('day')){
			  jQuery(this).removeClass('ui-selected')
		  }else{
			  result.append( " #" + ( jQuery(this).attr('id')) );
		  }
		  
		});
		
	  }
	}
	);
  } );