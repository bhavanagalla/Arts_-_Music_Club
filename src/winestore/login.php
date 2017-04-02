<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WineStore</title>
<style type="text/css">
fieldset
{
	display:block;
	padding-left:2px;
	padding-right:2px;
}
input[type=submit],input[type=reset],input[type=button] {
	margin-top: 0px;
	border: 0;
	border-radius: 2px;
	color: white;
	padding: 10px;
	text-transform: uppercase;
	font-weight: 400;
	font-size: 0.7em;
	color:#FFF;
	letter-spacing: 1px;
	background-color: #191614;
	cursor:pointer;
	outline: none;
}
</style>
<link href="http://cs99.bradley.edu/~bgalla/Assignment1/css/events.css" rel="stylesheet" type="text/css" />
<link href="http://cs99.bradley.edu/~bgalla/Assignment1/css/samplecss.css" rel="stylesheet" type="text/css" />
<link href="http://cs99.bradley.edu/~bgalla/Assignment1/images/favicon.png" rel="icon" type="image/x-icon" />
<style>
body {
  color: #222;
  font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  font-weight: 300;
  font-size: 15px;
 overflow-x:hidden;
background-size: cover;
background-position: top center;
background-repeat: no-repeat;
background-attachment: fixed;

}
nav {
  background-color: #fff;
  border: 1px solid #dedede;
  border-radius: 4px;
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.055);
  color: #888;
  display: block;
  margin: 8px 22px 8px 22px;
  overflow: hidden;
  width: 98%; 
}
nav ul
{
	margin: 0;
	padding: 0;
}

nav ul li {
display: inline-block;
list-style-type: none;
-webkit-transition: all 0.2s;
-moz-transition: all 0.2s;
-ms-transition: all 0.2s;
-o-transition: all 0.2s;
transition: all 0.2s; 
}
nav > ul > li > a {
color: #aaa;
display: block;
line-height: 56px;
padding: 0 24px;
text-decoration: none;
}
nav ul {
margin: 0;
padding: 0;
}
nav ul li {
display: inline-block;
list-style-type: none;
-webkit-transition: all 0.2s;
-moz-transition: all 0.2s;
-ms-transition: all 0.2s;
-o-transition: all 0.2s;
transition: all 0.2s; 
}
nav > ul > li > a > .caret {
border-top: 4px solid #aaa;
border-right: 4px solid transparent;
border-left: 4px solid transparent;
content: "";
display: inline-block;
height: 0;
width: 0;
vertical-align: middle;
-webkit-transition: color 0.1s linear;
-moz-transition: color 0.1s linear;
-o-transition: color 0.1s linear;
transition: color 0.1s linear; 
}
 nav > ul > li:hover {
background-color: rgb( 40, 44, 47 );
}
 nav > ul > li:hover > a {
color: rgb( 255, 255, 255 );
}
nav > ul > li:hover > a > .caret {
border-top-color: rgb( 255, 255, 255 );
}
</style>
<script type="text/javascript">
  $(function() {
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
  {
    $('li').has('ul').mouseover(function(){
        $(this).children('ul').css('visibility','visible');
        }).mouseout(function(){
        $(this).children('ul').css('visibility','hidden');
        })
  }
});
function outputUpdate(vol) {
	document.querySelector('#volume').value = vol;
}
</script>
<link href="http://cs99.bradley.edu/~bgalla/Assignment1/images/favicon.png" rel="icon" type="image/x-icon" />
</head>
<body background="http://cs99.bradley.edu/~bgalla/Assignment1/images/.jpg" bgproperties="background-size:100%"; display="block">
<?php
 
require "db.inc";


// Test for user input
     try
     {
      if (!($connection = @ mysql_connect($hostName, $username, $password)))
      throw new Exception('Could not connect to database:'.mysql_error());
     }
     catch(Exception $e)
     {
         echo 'Caught Exception: ',  $e->getMessage(), "\n";
     }

    if (!mysql_select_db($databaseName, $connection))
	die('cant use' . databaseName.':'.mysql_error());
	echo 'connected successfully';
	echo'<br>';
$user_name = mysqlclean($_POST, "username", 30, $connection);
session_start();

 $_SESSION['user'] = $user_name;

 if (isset($_SESSION['user'])) {
 ?>

<div id="snow">
<h2 align="center" style="color:#FFF;font-family:Jokerman;font-size:32px"> Wine Store</h2>
<nav>
<ul>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/Home.html" target="_top">Home</a></li>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/Login.html" target="_top">Login</a></li>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/SearchWines.html" target="_top">Search Wines</a></li>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/CreateNewWine.html" target="_top">Create new wine</a></li>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/ModifyWine.html">Modify existing wine info</a></li>
    <li><a href="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/DeleteWine.html">Delete existing wine</a></li>
</ul>
</nav>
<form name="regiform" action="http://cs99.bradley.edu/~bgalla/Assignment1/winestore/query.php" target="iframe1" method="get" enctype="multipart/form-data">
					
					
                    <fieldset><legend align="center"><h3>Search wines</h3></legend><br>
                    <table border="0" cellspacing="0" align="center">
					<tr>
                    	<td><lable style="font-family:Verdana,sans-serif; font-size:14px">Get Wines Info From Region</lable></td>
						<td><select name="regionName" multiple>
  								<option value="All">All</option>
  								<option value="Goulburn Valley">Goulburn Valley</option>
  								<option value="Rutherglen">Rutherglen</option>
  								<option value="Coonawarra">Coonawarra</option>
                                				<option value="Upper Hunter Valley">Upper Hunter Valley</option>
  								<option value="Lower Hunter Valley">Lower Hunter Valley</option>
                                				<option value="Barossa Valley">Barossa Valley</option>
  								<option value="Riverland">Riverland</option>
                                                                <option value="Margaret River">Margaret River</option>
                                				<option value="Swan Valley">Swan Valley</option>
							</select><br></td></tr>
					<tr>
                    	<td><lable style="font-family:Verdana,sans-serif; font-size:14px">Wine Type</lable></td>
						<td>
                        	 			<select name="wineType"required="required" >
											<option value="All">All</option>
											<option value="Sparkling">Sparkling</option>
											<option value="Fortified">Fortified</option>
											<option value="Sweet">Sweet</option>
											<option value="White">White</option>
											<option value="Red">Red</option>
                            				</select>
					</tr>
                    <tr>
                    	<td><lable style="font-family:Verdana,sans-serif; font-size:14px">Year</lable></td>
						<td> <select name="year" id="year">
										<option value=" ">year</option>
										<script language="javascript">
											for(i=1970;i<=2000;i++)
												document.write("<option>"+i+"</option>");
										</script>
                           			</select>
                                    <br></td>
                   	</tr>
					<tr>
						<td><lable style="font-family:Verdana,sans-serif; font-size:14px">Price Range</lable></td>
						<td><input type="decimal" id="price1" name="price1">-<input type="decimal" id="price2" name="price2">
			<br></td>
					</tr>
                    
					<tr>
						<td align="center" valign="top" colspan="2"><br>
                        				<input type="submit" name="wssearch" value="search">
							<input type="reset" name="rreset" value="Reset">
                        			</td>
					</tr>

			</table>  
            </fieldset>     
    </form>
    
 <iframe name="iframe1" id='iframe1' style="overflow: hidden; height: 100%; width:99%; position: absolute; alignment-adjust:central" frameborder="0" ></iframe>

 <?php

 } else {
   ?>
   Not logged in HTML and code here
   <?php
 }
</body>
</html>