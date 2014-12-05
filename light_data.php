<?php

// Connect to MySQL
            $link = mysql_connect( 'localhost', 'root', '' );
            if ( !$link ) {
              die( 'Could not connect: ' . mysql_error() );
            }

            // Select the data base
            $db = mysql_select_db( 'ws1314_g1', $link );
            if ( !$db ) {
              die ( 'Error selecting database \'test\' : ' . mysql_error() );
            }
            
            $node = $_GET['node'];
            
            // Fetch the data
            $query = "SELECT visible_light, submission_datetime FROM node_data WHERE node_id = $node ORDER BY submission_datetime ASC";
            $result = mysql_query( $query );

            // All good?
            if ( !$result ) {
              // Nope
              $message  = 'Invalid query: ' . mysql_error() . "\n";
              $message .= 'Whole query: ' . $query;
              die( $message );
            }

            // Print out rows
            $prefix = '';
            echo "[\n";
            while ( $row = mysql_fetch_assoc( $result ) ) {
              echo $prefix . " {\n";
              echo '  "category": "' . $row['submission_datetime'] . '",' . "\n";
              echo '  "visible_light": ' . $row['visible_light'] . '' . "\n";
              echo " }";
              $prefix = ",\n";
            }
            echo "\n]";

            // Close the connection
            mysql_close($link);
?>
