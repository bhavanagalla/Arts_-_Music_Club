<?
   $dbname = "s_bgalla";
   $dbhost = "cs99.bradley.edu";
   $dblogin = "bgalla";
   $dbpassword = "HiBVCSaD";

$conn = mysql_connect($dbhost,$dblogin,$dbpassword);
mysql_select_db($dbname,$conn);

if(isset($_GET['getCollegesByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysql_query("select wine_id,wine_name from wine where wine_name like '".$letters."%'") or die(mysql_error());
	#echo "1###select ID,collegeName from ajax_colleges where collegeName like '".$letters."%'|";
	while($inf = mysql_fetch_array($res)){
		echo $inf["wine_id"]."###".$inf["wine_name"]."|";
	}	
}
?>
