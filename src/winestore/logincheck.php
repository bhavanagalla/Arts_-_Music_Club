<?php
require 'authentication.inc';
require 'db.inc';

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

// Clean the data collected in the <form>
$loginUsername = mysqlclean($_POST, "loginUsername", 10, $connection);
$loginPassword = mysqlclean($_POST, "loginPassword", 10, $connection);

if (!mysql_selectdb("authentication", $connection))
  showerror();

session_start();

// Authenticate the user
if (authenticateUser($connection, $loginUsername, $loginPassword))
{
  // Register the loginUsername
  $_SESSION["loginUsername"] = $loginUsername;

  // Register the IP address that started this session
  $_SESSION["loginIP"] = $_SERVER["REMOTE_ADDR"];

  // Relocate back to the first page of the application
  header("Location: home.php");
  exit;
}
else
{
  // The authentication failed: setup a logout message
  $_SESSION["message"] = 
    "Could not connect to the application as '{$loginUsername}'";

  // Relocate to the logout page
  header("Location: logout.php");
  exit;
}
?>