<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineStore</title>
</style>
</head>
<body>
<?php
require "db.inc";

     try
     {
      if (!($connection = @ mysql_connect($hostName, $username, $password)))
      throw new Exception('Could not connect to database:'.mysql_error());
     }
     catch(Exception $e)
     {
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     }
    try
     {
    	if (!mysql_select_db($databaseName, $connection))
	throw new Exception('cant use' . databaseName.':'.mysql_error());
     }
    catch(Exception $e)
     {
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     }
       	echo 'connected successfully<br>';


	$wineid = $_POST['wineid'];
	$wineryid = $_POST['wineryid'];
		$winequery = "DELETE from wine Where wine_id= \"{$wineid}\";";
		$wineryquery= "DELETE from winery Where winery_id= {$wineryid} ";
		$inventoryquery = "DELETE from inventory Where wine_id= {$wineid} ";
   
	try{
     		if (!($wineres= @ mysql_query ($winequery , $connection)))
       			throw new Exception('Query error:'.mysql_error()."<br />".$winequery);
	}
	 catch(Exception $e)
     	{
         	echo 'Caught Exception: ',  $e->getMessage(), "\n";
     	}
	try{
     		if (!($wineryres= @ mysql_query ($wineryquery, $connection)))
       			throw new Exception('Query error:'.mysql_error()."<br />".$wineryquery);
	}
	 catch(Exception $e)
     	{
         	echo 'Caught Exception: ',  $e->getMessage(), "\n";
     	}
	try{
     		if (!($inventoryres= @ mysql_query ($inventoryquery , $connection)))
       			throw new Exception('Query error:'.mysql_error()."<br />".$inventoryquery);
	}
	 catch(Exception $e)
     	{
         	echo 'Caught Exception: ',  $e->getMessage(), "\n";
     	}

	//$wineres=mysql_query($winequery ,$connection) or die(mysql_error()."<br />".$winequery);

   	//$wineryres=mysql_query($wineryquery,$connection)or die(mysql_error()."<br />".$wineryquery);
   	  
   	//$inventoryres=mysql_query($inventoryquery ,$connection)or die(mysql_error()."<br />".$inventoryquery);
   	  
echo '<br>';
echo 'Record deleted';
echo '<br>';
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
	$body = "Hi,".$username.".Record deleted successfully!!!- " . $subject;
 
 	if (mail($to, $from ,$subject, $body)) {
   		echo("<p>Message successfully sent!</p>");
  	} else {
   		echo("<p>Message delivery");
	}
?>
<a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/SearchWines.html" target="_top">Check ur Deletion using search wines</a>

</body>
</html>