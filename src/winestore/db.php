<?php 
// server to connect to 
$hostname = "localhost"; 
 
// name of the database 
$databaseName = "s_bgalla"; 
 
// mysql username to access the database 
$username = "s_bgalla"; 
 
// mysql password to access the database 
$password = "HiBVCSaD"; 
 
//connect to mysql server 
$connection = mysql_connect($hostname , $username , $password) or die("Could not connect to Database because ".mysql_error()); 
 
//select the database 
mysql_select_db($databaseName) or die("could not select database because".mysql_error()); 
?>