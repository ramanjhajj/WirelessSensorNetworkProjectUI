<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <script src="http://code.jquery.com/jquery.js"></script>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/serial.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#selNode').on('change', function() {
                });
            
                AmCharts.loadJSON = function(url) {
                    // create the request
                    if (window.XMLHttpRequest) {
                    // IE7+, Firefox, Chrome, Opera, Safari
                    var request = new XMLHttpRequest();
                    } else {
                    // code for IE6, IE5
                    var request = new ActiveXObject('Microsoft.XMLHTTP');
                    }

                    // data is loaded
                    request.open('GET', url, false);
                    request.send();

                    // parse adn return the output
                    return eval(request.responseText);
                };
                
                AmCharts.ready(function() {
                // load the data
                var chartData = AmCharts.loadJSON('temp_data.php?node=6');

                  // SERIAL CHART    
                  chart = new AmCharts.AmSerialChart();
                  chart.pathToImages = "amcharts/images/";
                  chart.dataProvider = chartData;
                  chart.categoryField = "category";
                  //chart.dataDateFormat = "YYYY-MM-DD";
                  chart.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
                  
                  // GRAPHS

                  var graph1 = new AmCharts.AmGraph();
                  graph1.valueField = "sensirion_temp";
                  graph1.bullet = "round";
                  graph1.bulletBorderColor = "#FFFFFF";
                  graph1.bulletBorderThickness = 2;
                  graph1.lineThickness = 2;
                  graph1.lineAlpha = 0.5;
                  chart.addGraph(graph1);

                  // CATEGORY AXIS 
                  chart.categoryAxis.parseDates = true;
                  chart.categoryAxis.minPeriod = "mm";
                  
                  // WRITE
                  chart.write("chartdiv6");
                });
            });
        </script>
    </head>
    <div class="navbar navbar-fixed-top ">
  <div class="navbar-inner">
    <div class="container" style="width:1235px;">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

        <a href="#" class="brand">eAtmos</a> 
      <div class="nav-collapse">
       
	<p class="navbar-text pull-right">
       </p>
        <ul class="nav">
	  
        <li class="active"><a href="eAtmos.php">Temperature</a></li> 
	<li><a href="eAtmosPressure.php">Pressure</a></li>
	
    	<li><a href="eAtmosLight.php">Visible Light</a></li> 
        </ul>
      </div>
    </div>
  </div>
</div>
    <body style="margin-top: 80px; background-color: #e5e5e5">
        <?php
        // put your code here
        ?>
        <div class="container">
            <h2 class="span9">Temperature Details</h2>
            <select id="selNode" class="span2" style="margin-top: 20px;">
                <option value="6">Node 1</option>
                <option value="7">Node 2</option>
                <option value="8">Node 3</option>
            </select>
            
            <div class="block">
                <div class="navbar navbar-inner" style="margin-bottom: 0px; border-radius: 0px;">
                    <div class="muted pull-left" style="padding-top: 10px;">Visual Chart:</div>
                    </div>
                </div>
                <div class="block-content collapse in" style="border: 1px solid #d4d4d4;  border-top: 0px; background-color: white;">
                    <div id="chartdiv6" class="charts" style="width: 640px; height: 400px; margin: auto; display:block;"></div>
                </div>
                <br><br><br>
                <div class="navbar navbar-inner" style="margin-bottom: 0px; border-radius: 0px;">
                    <div class="muted pull-left" style="padding-top: 10px;">Detailed View:</div>
                    </div>
                
                <div class="block-content collapse in" style="border: 1px solid #d4d4d4;  border-top: 0px; background-color: white;">
                <table class="table">
                    <tr>
                        <th style='text-align: center; width: 45%;'>DateTime</th> 
                        <th style='text-align: center;'>Temperature</th>
                    </tr>
                    <?php
                        $link = mysql_connect( 'localhost', 'root', '' );
                        if ( !$link ) {
                                  die( 'Could not connect: ' . mysql_error() );
                                }

                                // Select the data base
                                $db = mysql_select_db( 'ws1314_g1', $link );
                                if ( !$db ) {
                                  die ( 'Error selecting database \'test\' : ' . mysql_error() );
                                }
                                // Fetch the data
                                $query = "SELECT sensirion_temp, submission_datetime FROM node_data WHERE node_id = 6 ORDER BY submission_datetime ASC";
                                $result = mysql_query( $query );

                                // All good?
                                if ( !$result ) {
                                  // Nope
                                  $message  = 'Invalid query: ' . mysql_error() . "\n";
                                  $message .= 'Whole query: ' . $query;
                                  die( $message );
                                }

                                // Print out rows
                               
                                while ( $row = mysql_fetch_assoc( $result ) ) {
                                  echo "<tr>";
                                  echo "<td style='text-align: center;'>" . $row['submission_datetime'] . "</td>";
                                  echo "<td style='text-align: center;'>" . substr($row['sensirion_temp'],0,5) . "</td>";
                                  echo "</tr>";
                                }
                                // Close the connection
                                mysql_close($link);
                    ?>
                </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
