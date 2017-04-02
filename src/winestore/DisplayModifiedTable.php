<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineStore</title>
<style type="text/css">

table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; width:auto}
table.db-table th	{ background:#191614; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
tr:nth-child(even){background-color: #f2f2f2}
tr:nth-child(odd){background-color: #f2f2f2}
th{color:#FFF;}
</style>
</head>
<body>
<?php

// server to connect to 
$server = "localhost"; 
 
// name of the database 
$database = "s_bgalla"; 
 
// mysql username to access the database 
$db_user = "s_bgalla"; 
 
// mysql password to access the database 
$db_pass = "HiBVCSaD"; 
 
//connect to mysql server 
$link = mysql_connect($server, $db_user, $db_pass) or die("Could not connect to Database because ".mysql_error()); 
 
//select the database 
mysql_select_db($database) or die("could not select database because".mysql_error()); 


require "db.inc";

//inventory table
$showiTable="SELECT * FROM inventory ORDER BY lastmodified DESC LIMIT 5";
$resulti=mysql_query($showiTable) or die("query error");

echo "<table border cellpadding=0 cellspacing=0 class=db-table align=center>";
echo"<tr>";
// These are the column lables that will be displayed
echo"<th>Wine Id</th>";
echo"<th>Inventory Id</th>";
echo"<th>On Hand</th>";
echo"<th>Cost</th>";
echo"<th>Created Date</th>";
echo"<th>Last Modified</th>";
echo"</tr>";

while($infoi = mysql_fetch_array($resulti))
	{
		echo"<tr><td>".$infoi['wine_id'] . "</td>";
		echo"<td>".$infoi['inventory_id'] . "</td>";
		echo"<td>".$infoi['on_hand'] . "</td>";
		echo"<td>".$infoi['cost'] . "</td>";
		echo"<td>".$infoi['date_added'] . "</td>";
		echo"<td>".$infoi['lastmodified'] . "</td></tr>";

	}
echo "</table>"

?>
</body>
</html>