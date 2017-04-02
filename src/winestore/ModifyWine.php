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

	echo "<p style='color:green;'>connected successfully</p><br>";
	
	$wine_name = mysqlclean($_GET, "wine_name", 30, $connection);
	//echo "<p style='color:purple;'>wine name: $wine_name </p>,\t";

	$wineid = mysql_query("SELECT wine_id from wine WHERE wine_name=\"{$wine_name}\";") or die("query error");
	$wine_id= mysql_result($wineid, 0);
	//echo "<p style='color:purple;'>wine id: $wine_id </p>,\t";

	$wine_type = mysqlclean($_GET, "wine_type", 30, $connection);
	//echo "<p style='color:purple;'>wine type: $wine_type </p>,\t";

	$winetype_id = mysql_query("SELECT wine_type_id from wine_type WHERE wine_type=\"{$wine_type}\";") or die("query error");
	$wine_type_id = mysql_result($winetype_id, 0);
	//echo "<p style='color:purple;'>wine type_id: $wine_type_id</p> ,\t";

	$year = mysqlclean($_GET, "year", 30, $connection);
	//echo "<p style='color:purple;'>Year: $year </p>,\t";

	$price = mysqlclean($_GET, "price", 30, $connection);
	//echo "<p style='color:purple;'>Price: $price</p> ,\t";

	$winery_name = mysqlclean($_GET, "winery_name", 30, $connection);
	//echo "<p style='color:purple;'>Winery name: $winery_name </p>,\t";

	$wineryid = mysql_query("SELECT  winery_id from winery WHERE winery_name=\"{$winery_name}\";") or die("query error");
	$winery_id = mysql_result($wineryid, 0);
	//echo "<p style='color:purple;'>Winery Id: $winery_id </p>,\t";	
	
	$region_name = mysqlclean($_GET, "region_name", 30, $connection);
	//echo "<p style='color:purple;'>Region name: $region_name<br>";

	$regionid = mysql_query("SELECT region_id from region WHERE region_name=\"{$region_name}\";") or die("query error");
	$region_id = mysql_result($regionid, 0);
	//echo "<p style='color:purple;'>Region-Id: $region_id<br>";
	
echo "<p style='color:purple;'>wine name: $wine_name ,wine id: $wine_id,wine type: $wine_type,wine type_id: $wine_type_id,Year: $year,<br>
					Price: $price, Winery name: $winery_name , Winery Id: $winery_id ,Region name: $region_name,Region-Id: $region_id</p>";


	if ($wine_name !=NULL && $winery_name !=NULL && $price!=NULL && $wine_type!=NULL && $year!=NULL && $region_id!=NULL){
     		$winequery = "UPDATE wine SET wine.wine_name='{$wine_name}',wine.wine_type='{$wine_type_id}',wine.year='{$year}'
			 WHERE wine.wine_id={$wine_id}
				AND wine.winery_id={$winery_id}";
     		$wineryquery= "UPDATE winery SET winery.winery_name='{$winery_name}', winery.region_id='{$region_id}'
			 WHERE winery.winery_id={$winery_id}";
     		$inventoryquery = "UPDATE inventory SET inventory.cost='{$price}'
			 WHERE inventory.wine_id={$wine_id}";
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
      }	  	  

		//$wineres=mysql_query($winequery ,$connection) or die(mysql_error()."<br /> wine table".$winequery);
		//$wineryres=mysql_query($wineryquery,$connection) or die(mysql_error()."<br /> winery table".$wineryquery);
		//$inventoryres=mysql_query($inventoryquery ,$connection) or die(mysql_error()."<br /> inventory table".$inventoryquery);

			

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
	$body = "Hi,".$username.".Record modified successfully!!!- " . $subject;
 
 	if (mail($to, $from,$subject, $body)) {
   		echo("<p>Message successfully sent!</p>");
  	} else {
   		echo("<p>Message delivery");
	}
?>
<h3>Resently Modified records in Inventory</h3>
<iframe name="iframe1" id='iframe1'src="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DisplayModifiedTable.php" style="height: 30%; width:99%; position: left; alignment-adjust:left" frameborder="0" ></iframe>
<h3>Resently Modified records in Wine</h3>
<iframe name="iframe2" id='iframe2'src="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DisplayModifiedWine.php" style="height: 30%; width:99%; position: left; alignment-adjust:left" frameborder="0" ></iframe>
<h3>Resently Modified records in Winery</h3>
<iframe name="iframe3" id='iframe3'src="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DisplayModifiedWinery.php" style="height: 35%; width:99%; position: left; alignment-adjust:left" frameborder="0" ></iframe>
</body>
</html>
