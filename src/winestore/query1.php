<?php
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
	$subject = "Wine Store";
	$body = "Hi,".$username.".New wine record created successfully!!!- " . $subject;
 
 	if (mail($to, $subject, $body)) {
   		echo("<p>Message successfully sent!</p>");
  	} else {
   		echo("<p>Message delivery");
	}
?>