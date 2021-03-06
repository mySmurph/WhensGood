var headers = document.getElementsByTagName('th');
var dbTable = document.getElementById('db_table_options'); 

for(var i=0; i<headers.length; i++) {
    headers[i].addEventListener('click', function(){sortTable(this);});
}
dbTable.addEventListener('change', setAttributeOptions);

function setAttributeOptions(){
	var attOps = document.getElementById('db_attribute_options'); 
	attOps.innerHTML = '';
	var attributes = [];
	switch(dbTable.value){
		case 'Users': attributes = ['', 'UserID', 'UserType', 'UserName', 'RSVP', 'Email', 'CalenderFile', 'Password'];
			break;
		case 'Events': attributes = ['', 'EventCode', 'EventTitle', 'Duration', 'Deadline', 'EventPassword'];
			break;
		case 'Days': attributes = ['', 'EventCode', 'UserID', 'EventDate', 'TimeArray'];
			break;
		case 'LOGS': attributes = ['', 'LogEntry', 'AssociatedUserID', 'DateTime', 'Description'];
			break;
	}
	var options = '<select aria-label="Whens Good DB Table" class = "input_type_text full" name="db_attribute" id="db_attribute">';
	for(var i = 0; i < attributes.length ; i++){
		options += "<option value=\""+attributes[i]+"\">"+attributes[i]+"</option>";
	}
	options += '</select>';
	attOps.innerHTML = options;
}

var ascending = false;
function sortTable(columnHeader) {
	ascending = !ascending;
	var column = columnHeader.cellIndex;
	var table, rows, switching, i, x, y, shouldSwitch;
	table = document.getElementById("results_table");

	switching = true;
	/*Make a loop that will continue until
	no switching has been done:*/
	while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
		first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
			//start by saying there should be no switching:
			shouldSwitch = false;
			/*Get the two elements you want to compare,
			one from current row and one from the next:*/
			if(ascending){
				x = rows[i].getElementsByTagName("TD")[column];
				y = rows[i + 1].getElementsByTagName("TD")[column];
			}else{
				y = rows[i].getElementsByTagName("TD")[column];
				x = rows[i + 1].getElementsByTagName("TD")[column];
			}

			//check if the two rows should switch place:
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				//if so, mark as a switch and break the loop:
				shouldSwitch = true;
				break;
			}
		}
		if (shouldSwitch) {
			/*If a switch has been marked, make the switch
			and mark that a switch has been done:*/
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
		}
	}
}