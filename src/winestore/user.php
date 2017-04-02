<?php
$file = fopen("http://cs99.bradley.edu/~bgalla/Assignment1/cgi-bin/singlelogin.txt", "r");
$i = 0;
while (!feof($file)) {

$line_of_text = fgets($file);
$array = explode(' ', $line_of_text);
$username=$array[0];
   $email=$array[1];

}
fclose($file);

echo " username:$username";
echo " email:$email";

}
?>