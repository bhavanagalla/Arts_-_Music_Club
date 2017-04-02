<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineStore</title>
<style type="text/css">

table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
table.db-table th	{ background:#191614; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
tr:nth-child(even){background-color: #f2f2f2}
tr:nth-child(odd){background-color: #f2f2f2}
th{color:#FFF;}
</style>
</head>
<body>
<?php

require 'db.inc';

// Show all wines in a region in a <table>
  function displayWinesList($connection,$query,$regionName,$wineType)
                            
  {
     // Run the query on the server
     try{
     		if (!($result = @ mysql_query ($query, $connection)))
       			throw new Exception('Query error:'.mysql_error());
	}
	 catch(Exception $e)
     	{
         	echo 'Caught Exception: ',  $e->getMessage(), "\n";
     	}

     // Find out how many rows are available
     $rowsFound = @ mysql_num_rows($result);

     // If the query has results ...
     if ($rowsFound > 0)
     {
         // ... print out a header
         print "<span style='font-family:Times New Roman, Times, serif;color:Red;'> Wines of $regionName region name and $wineType winetype</span><br>";
		 print "<span style='font-family:Times New Roman, Times, serif;color:Blue;'> {$rowsFound} records found matching your criteria</span><br>";
         // and start a <table  border width=50%>.
         print "\n<table cellpadding=0 cellspacing=0 class=db-table align=center>\n<tr>" .
               "\n\t<th>Wine ID</th>" .
               "\n\t<th>Wine Name</th>" .
               "\n\t<th>Wine Type</th>" .
               "\n\t<th>Year</th>" .
               "\n\t<th>Price</th>" .
	       "\n\t<th>Region Name</th>" .
               "\n\t<th>Winery</th>\n</tr>";

         // Fetch each of the query rows
         while ($row = @ mysql_fetch_array($result))
         {
            // Print one row of results
            print "\n<tr>\n\t<td>{$row["wine_id"]}</td>" .
                  "\n\t<td>{$row["wine_name"]}</td>" .
		  "\n\t<td>{$row["wine_type"]}</td>" .
                  "\n\t<td>{$row["year"]}</td>" .
		  "\n\t<td>{$row["cost"]}</td>" .
                  "\n\t<td>{$row["region_name"]}</td>" .
                  "\n\t<td>{$row["winery_name"]}</td>\n</tr>";
         } // end while loop body

         // Finish the <table>
         print "\n</table>";
     } // end if $rowsFound body
   else
   print" 0 records found<br>";
     // Report how many rows were found

  } // end of function

  // Connect to the MySQL server
  try
     {
      if (!($connection = @ mysql_connect($hostname, $username, $password)))
      throw new Exception('Could not connect to database:'.mysql_error());
     }
     catch(Exception $e)
     {
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     }

  // Secure the user parameter $regionName
  $regionName = mysqlclean($_GET, "regionName", 30, $connection);
  $wineType = mysqlclean($_GET, "wineType", 30, $connection);
  $price1 = mysqlclean($_GET, "price1", 30, $connection);
  $price2 = mysqlclean($_GET, "price2", 30, $connection);
  $year = mysqlclean($_GET, "year", 30, $connection);
 
   try
	{
    	if (!mysql_select_db($databaseName, $connection))
	throw new Exception('cant use' . databaseName.':'.mysql_error());
	}
    catch(Exception $e)
     	{
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     	}

	echo "<p style='color:green;'>connected successfully</p><br>";


  // Start a query ...
  $query = "SELECT  wine.wine_id, wine_name,wt.wine_type,region_name,cost,description,wine.year, winery_name
            FROM   winery, region, wine, inventory,wine_type wt
            WHERE  winery.region_id = region.region_id 
            AND    wine.winery_id = winery.winery_id
			AND    wine.wine_id = inventory.wine_id";

   // ... then, if the user has specified a region, add the regionName 
   // as an AND clause ...
   if (isset($regionName) && $regionName != "All")
     $query .= " AND region_name = \"{$regionName}\"";

   if (isset($wineType) && $wineType != "All")
     $query .= " AND wt.wine_type = \"{$wineType}\"";
	if (isset($year) && $year != " ")
     $query .= " AND year = \"{$year}\"";

   if($price1!='' and $price2!='' and $year!='') {
	 $query .= " AND cost >= \"{$price1}\"";
	 $query .= " AND cost <= \"{$price2}\"";
	 $query .= " AND year <= \"{$year}\"";
   // ... and then complete the query.
         $query .= " ORDER BY wine_id";
}
   // run the query and show the results
   displayWinesList($connection, $query, $regionName,$wineType);

//mail
$path='http://cs99.bradley.edu/~bgalla/Assignment1/winestore/query.php';
$file = fopen("http://cs99.bradley.edu/~bgalla/Assignment1/cgi-bin/singlelogin.txt", "r");
$i = 0;
while (!feof($file)) {

$line_of_text = fgets($file);
$array = explode(' ', $line_of_text);
$username=$array[0];
$email=$array[1];

}
fclose($file);
echo "$email<br>";

	$to = $email;
	$from="noreply@music.com";
	$subject = "Wine Store";
	$body = "Hi,".$username.".Record search successfully completed!!!
		
		- " . $subject;
 
 	if (mail($to, $from,$subject, $body)) {
   		echo("<p>Message successfully sent!</p>");
  	} else {
   		echo("<p>Message delivery");
	}

?>
<!--
$FromName="Music Club";
$FromEmail="noreply@music.com";
$ToEmail=$email;
    if(($Content = file_get_contents("http://cs99.bradley.edu/~bgalla/Assignment1/winestore/query.php")) === false) {
      $Content = "";
    }

    $Headers  = "MIME-Version: 1.0\n";
    $Headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $Headers .= "From: ".$FromName." <".$FromEmail.">\n";
    $Headers .= "Reply-To: ".$ReplyTo."\n";
    $Headers .= "X-Sender: <".$FromEmail.">\n";
    $Headers .= "X-Mailer: PHP\n"; 
    $Headers .= "X-Priority: 1\n"; 
   $Headers .= "Return-Path: <".$FromEmail.">\n";  
   if(mail($ToEmail, $Subject, $Content, $Headers) == false) {
        //Error
    }
-->
</body>
</html>