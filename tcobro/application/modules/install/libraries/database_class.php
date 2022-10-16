<?php

class Database_class {

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Create the prepared statement
//		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database'].' CHARACTER SET charset_name utf8 -- UTF-8 Unicode COLLATE utf8_bin');
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database'].' CHARACTER SET utf8 -- UTF-8 Unicode COLLATE utf8_bin');

		// Close the connection
		$mysqli->close();

		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
            set_time_limit(0);
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('./resources/install/assets/1_install.sql');
		$query .= file_get_contents('./resources/install/assets/2_config.sql');
                               		
		// Execute a multi query                
                try {
                    $mysqli->multi_query($query);                    
                    // Close the connection
                    $mysqli->close();

                    return true;
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                    return false;
                }
                                             
                
//            if ($mysqli->multi_query($query)) {
//                do {
//                    // store first result set 
//                    if ($result = $mysqli->store_result()) {
//                        while ($row = $result->fetch_row()) {
//                            // do something with the row
//                        }
//                        $result->free();
//                    }
//                    else { /*error_report();*/ echo $mysqli->errno; }
//                } while ($mysqli->next_result());
//            }
//            else {  /*error_report();*/ echo $mysqli->errno; }                

	}
}