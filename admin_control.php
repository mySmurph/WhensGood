<?php
	// session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="content-script-type" content="text/tcl" />
  <title>Database Query Tool</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />  
</head>

<body>
<?php 
	include ("functions.php");
	printNavigation();

?>
  
    <main id="main">
    <h1>Database Query Tool     <span class = 'button red small'>
      <a href = "admin_portal.php?access=0">&nbsp;&nbsp;&nbsp;Log Out&nbsp;&nbsp;&nbsp;</a>
</span></h1>
    <form class="alert" method = "post" action = "admin_control.php" id = "form">
        <div class = " grid_container">
            <div>
                <ul>
                    <li>
                        <label aria-label="When's Good DB Table">Table<br/></label>
                        <select aria-label="When's Good DB Table" class = "text_input full" name="db_table_options" id="db_table_options">
                            <option value="" selected></option>
                            <option value="Users">Users</option>
                            <option value="Events">Events</option>
                            <option value="Days">Days</option>
                            <option value="LOGS">LOGS</option>
                        </select>
                    </li>
                    
                    <li>
                        <label aria-label="When's Good DB Table">Attribute<br/></label>
                        <span id = "db_attribute_options">
                            <select aria-label="When's Good DB Table" class = "text_input full" name="db_attribute" id="db_attribute">
                                <option value="" selected></option>
                            </select>
                            </span>
                    </li>

                    <li>
                        <label aria-label="key_term">Key Term<br/></label>
                        <input type = "text" class = "text_input full" name = "key_term" id = "key_term" />
                    </li>
                </ul>

            </div>

            <div>
            <ul>
                <li>
					<label>Please Enter a Database Query<br />
                    <textarea id = "db_query" name = "db_query" class="text_input_full">
SELECT * FROM Days Order BY EventDate;
                    </textarea>
                    </label>
				</li>
			</ul>
            </div>
        </div>
        

				<div>
					<button type = "submit" class="button red span" id = "admin_password_submit">Submit</button><br />
				</div>
	</form>

     <?php 

        // access the When's Good database with mysql
        $db_query = htmlspecialchars($_POST["db_query"]);

        // delete leading and trailing whitespace and remove backslashes
        trim($db_query);
        $db_query = stripslashes($db_query);

        if($db_query != ''){
            $db_connection = connectDB();
            $result = mysqli_query($db_connection, $db_query);

            $num_rows = mysqli_num_rows($result);
            if(!$result){
                print "<p>Error - the query could not be executed</p>";
                // exit;
            }else{
                // $num_rows = mysqli_num_rows($result);
                // // if there are rows in the result, put them into the table
                if($num_rows > 0){
                    print "<table title='Whens Good Data' summary='This table contains information related to the user and organizer data.'><tr>";
        
                    $a_row = mysqli_fetch_assoc($result);
                    $num_rows = mysqli_num_rows($result);
                    $col_headers = array_keys($a_row);

                    echo "<table title='Whens Good Data' summary='This table contains information related to the user and organizer data.' aria-label = \"Table to display information for  ".$db_query."\" id = \"results_table\"> <caption> <div class=\"white query\"> <h1>Query</h1>".$db_query." </div> </caption>";
                    echo "<tr>";
                        foreach($col_headers as &$header){
                            echo "<th id = \"".$header."\">".$header."</th>";
                        }
                        unset($header);
                    echo "</tr>";
        
                    for($i = 0; $i<$num_rows; $i++){
                        echo "<tr>";
                        $values = array_values($a_row);
                        $j = 0;
                        foreach($values as &$val){
                            $value = htmlSpecialchars($val);
                            
                            echo "<td headers = \"".$col_headers[$j++]."\">".$value."</td>";
                        }
                        unset($val);
                        $a_row = mysqli_fetch_assoc($result);
                        echo "</tr>";
                    }
                    unset($row);

			        echo"</table>";
                } 
                else { // if the result doesn't return any queries, then return the message below
                    print "There were no such rows in the table<br />";
                }
            }
            $db_connection->close();
        }

    ?>
    <script type="text/javascript" src="script/sort.js"></script>
    </main>
</body>
</html>