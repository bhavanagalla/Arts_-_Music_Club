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

	$wineid = mysql_query("SELECT COUNT(*) from wine;") or die("query error");
	$wine_id= mysql_result($wineid, 0)+1;
	echo "wine id: $wine_id ,";
	$wine_name = mysqlclean($_GET, "wine_name", 30, $connection);
	echo "wine name: $wine_name ,";

	$wine_type = mysqlclean($_GET, "wine_type", 30, $connection);
	echo "wine type: $wine_type ,";

	$winetype_id = mysql_query("SELECT wine_type_id from wine_type WHERE wine_type=\"{$wine_type}\";") or die("query error");
	$wine_type_id = mysql_result($winetype_id, 0);
	echo "wine type_id: $wine_type_id ,";

	$year = mysqlclean($_GET, "year", 30, $connection);
	echo "Year: $year ,";

	$price = mysqlclean($_GET, "price", 30, $connection);
	echo "Price: $price ,";

	$on_hand = mysqlclean($_GET, "on_hand", 30, $connection);
	echo "On Hand: $on_hand ,";

	$winery_name = mysqlclean($_GET, "winery_name", 30, $connection);
	echo "Winery name: $winery_name ,";

	$wineryid = mysql_query("SELECT COUNT(*) from winery;") or die("query error");
	$winery_id = mysql_result($wineryid, 0)+1;
	echo "Winery Id: $winery_id ,<br>";	
	
	$region_name = mysqlclean($_GET, "region_name", 30, $connection);
	echo "Region name: $region_name ,";

	$regionid = mysql_query("SELECT region_id from region WHERE region_name=\"{$region_name}\";") or die("query error");
	$region_id = mysql_result($regionid, 0);
	echo "Region-Id: $region_id <br>";
	   
	
	// Insert the new wine entry
	$winequery =("INSERT INTO wine (wine_id,wine_name,wine_type,year,winery_id,description) VALUES ('$wine_id','$wine_name','$wine_type_id','$year','$winery_id',NULL)");

	$wineryquery= "INSERT INTO inventory (wine_id,inventory_id,on_hand,cost,date_added) VALUES ('$wine_id', '1', '$on_hand', '$price', CURRENT_TIMESTAMP)";

	$inventoryquery = "INSERT INTO winery (winery_id, winery_name, region_id) VALUES ('$winery_id', '$winery_name', '$region_id')"; 



   // Insert the entry
  	// $wineres=mysql_query($winequery ,$connection) or die(mysql_error()."<br />".$winequery);

   	//$wineryres=mysql_query($wineryquery,$connection)or die(mysql_error()."<br />".$wineryquery);
   	  
   	//$inventoryres=mysql_query($inventoryquery ,$connection)or die(mysql_error()."<br />".$inventoryquery);
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
	$body = "Hi,".$username.".Record created successfully!!!- " . $subject;
 
 	if (mail($to,$from,$subject, $body)) {
   		echo("<p>Message successfully sent!</p>");
  	} else {
   		echo("<p>Message delivery");
	}

echo 'Resently inserted records in wines<br>';
?>

<iframe name="iframe1" id='iframe1'src="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DisplayInsertedWines.php" style="height: 35%; width:99%; position: left; alignment-adjust:left" frameborder="0" ></iframe>
<?php
$path='DisplayInsertedInventory.php';
echo 'Resently inserted records in Inventory<br>';
?>
<iframe name="iframe2" id='iframe1' src="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DisplayInsertedInventory.php" style="height: 35%; width:99%; position: left; alignment-adjust:left" frameborder="0" ></iframe>

</body>
</html>