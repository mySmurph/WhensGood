<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="content-script-type" content="text/tcl" />
  <title>Database Query Tool</title> 
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />  
</head>

<body>
    <nav>
		<a href="#main" aria-label="Skip to main"></a>
		<a href="landing.html"><img src="LogoWhensGoodLogo.svg" class="img" alt="comment pic" /></a>
		<ul class="list">
            <li>
                <a class="button" href="db_query.html">Run New Query</a>
            </li>
			<li>
                <a class="button" href="landing.html">Logout</a>
            </li>
		</ul>
    </nav>
  
    <main id="main">
    <h1>Database Query Tool</h1>

     <?php 
        // access the When's Good database with mysql
        $db_query = htmlspecialchars($_POST["db_query"]);
        print "<p>$db_query</p>";

        $db_connection = mysqli_connect("db", "user", "test", "myDb");                // use for the local database on group pcs via Docker
        // $db_connection = mysqli_connect("localhost", "group4", "IjChbKtynlNZ", "group4");  // use for the database on the school server
        if(!$db_connection){
            print "<p>Connection to database failed!!</p>";
            exit(); 
        }

        // delete leading and trailing whitespace and remove backslashes
        trim($db_query);
        $db_query = stripslashes($db_query);

        $query_result = mysqli_query($db_connection, $db_query);

        if(!$query_result){
            print "<p>Error - the query could not be executed</p>";
            exit;
        }

        $num_rows = mysqli_num_rows($query_result);

        // // if there are rows in the result, put them into the table
        if($num_rows > 0){
            print "<table title='Whens Good Data' summary='This table contains information related to the user and organizer data.'><tr>";


            // produce the column titles
            $keys = array_keys($row_data);
            while($row_data = mysql_fetch_assoc($query_result)){                   
                print "<th id = \"" . $row_data['Field'] . "\">";                                           // !!!! need to check to see if this works
                print $row_data['Field'] . "</th>";                                                         // !!!! need to check to see if this works
            }
            print "</tr>";

        // reset the pointer to the first row in the result from the database                                !!!!! need to check to see if this works
        mysql_data_seek($query_result, 0);

        $row_data = mysqli_fetch_assoc($query_result);
        $num_columns = mysqli_num_fields($query_result);

            // output the data for the query
            // so for each row
            for($row_number = 0; $row_number < $num_rows; ++$row_number){
                print "<tr>";   // opening to table row
                
                // gets the data from each cell and places it inside the $row_values_array
                $row_values_array = array_values($row_data);

                // iterate through the data cells in each row
                for($column_number = 0; $column_number < $num_columns; ++$column_number){
                    $cell_data = htmlspecialchars($row_values_array[$column_number]);
                    print "<td headers = \"" . row_data['Field'] . "\">";                                    // !!!! need to check to see if this works
                    print $cell_data . "</td>";
                }

                print "</tr>";  // closing to table row

                // updates row data to the next row of the result
                $row_data = mysqli_fetch_assoc($query_result);  
            }
            print"</table>";
        } 
        else { // if the result doesn't return any queries, then return the message below
            print "There were no such rows in the table<br />";
        }
    ?>
    </main>
</body>
</html>