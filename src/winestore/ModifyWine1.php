<?php
require 'db.inc';

$rec_limit = 10;

 try
     {
      if (!($connection = @ mysql_connect($hostname, $username, $password)))
      throw new Exception('Could not connect to database:'.mysql_error());
     }
     catch(Exception $e)
     {
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     }
if(! $connection )
{
  die('Could not connect: ' . mysql_error());
}
if (!mysql_select_db($databaseName, $connection))
     showerror();
/* Get total number of records */
$sql = "SELECT count(wine_id) FROM wine ";
$retval = mysql_query( $sql, $connection );

if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
$row = mysql_fetch_array($retval, MYSQL_NUM );
$rec_count = $row[0];
$i=-1;
while($i<=$rec_count/$rec_limit-1)
{
	$m=$i+1;
	echo "<a href=\"$_PHP_SELF?page=$i\">$m</a> |";
	$i=$i+1;
}
if( isset($_GET{'page'} ) )
{
   $page = $_GET{'page'} + 1;
   $offset = $rec_limit * $page ;
}
else
{
   $page = 0;
   $offset = 0;
}

$left_rec = $rec_count - ($page * $rec_limit);

$sql = "SELECT wine.wine_id, wine_name,wine_type, year, cost, winery_name
            FROM   winery,wine,inventory
            WHERE  wine.winery_id = winery.winery_id
			AND wine.wine_id = inventory.wine_id
			ORDER BY wine_id
			LIMIT $offset, $rec_limit";
	   

$retval = mysql_query( $sql, $connection );
if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}

print "\n<table>\n<tr>" .
               "\n\t<th>Wine ID</th>" .
               "\n\t<th>Wine Name</th>" .
               "\n\t<th>Wine Type</th>" .
               "\n\t<th>Year</th>" .
			   "\n\t<th>Price</th>" .
               "\n\t<th>Winery Name</th>\n</tr>";
 while ($row = @ mysql_fetch_array($retval))
         {
            // Print one row of results
           print "\n<tr>\n\t<td>{$row["wine_id"]}</td>" .
                  "\n\t<td>{$row["wine_name"]}</td>" .
				  "\n\t<td>{$row["wine_type"]}</td>" .
                  "\n\t<td>{$row["year"]}</td>" .
				  "\n\t<td>{$row["cost"]}</td>" .
                  "\n\t<td>{$row["winery_name"]}</td>\n</tr>";
         } // end while loop body

print "\n</table>\n";

if( $page > 0 )
{
   $last = $page - 2;
   echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
   echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
}
else if( $page == 0 )
{
   echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
}
else if( $left_rec < $rec_limit )
{
   $last = $page - 2;
   echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a>";
}


mysql_close($conn);
?>