var selection =[];
$(document).ready(function() {
	$("#selectable-SUN, #selectable-MON, #selectable-TUE, #selectable-WED, #selectable-THR, #selectable-FRI, #selectable-SAT" ).selectable(
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
	  if (windows.length <1){
		  alert("no time selected");
	  }
  };