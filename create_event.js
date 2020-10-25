$(document).ready(function() {
	$( "#selectable-SUN, #selectable-MON, #selectable-TUE, #selectable-WED, #selectable-THR, #selectable-FRI, #selectable-SAT" ).selectable(
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