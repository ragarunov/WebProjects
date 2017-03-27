<?php
/*
Ronen Agarunov
029-490-158
Section C - int322_163c17
*/

//Declare text file to read from
$file = "deadlanguages.txt";

//Connect to SQL Server
$lines = file('/home/int322_163c17/secret/topsecret.txt');
$dbserver = trim($lines[0]);
$uid = trim($lines[1]);
$pw = trim($lines[2]);
$dbname = trim($lines[3]);

$link = mysqli_connect($dbserver, $uid, $pw, $dbname) or die('Could not connect: ' . mysqli_error($link));

//Include the file
require $file;

//Get data out of file
$content = file_get_contents($file);

//Regular expressions that picks all instances of " wh* " and counts it
$LookString = preg_match_all("/\s*wh.\s*/", $content);


//Opens file for writing, replaces all instances of round brackets with "(*wh*)" and counts how many changes have been made
$fp = fopen($file, 'w');
$countA = 0;
$str = preg_replace('/\(.+\)/', '(*wh*)', $content, -1, $countA);
fwrite($fp, $str);
fclose($fp);


//Writes to a new file 'newfile.txt', goes to position 782,  and replaces all occurrences of "wha" to "which" from position 782 until the end and counts
$fp = fopen($file, 'r');
$oldf = fread($fp, 1740);
fclose($fp);
file_put_contents('newfile.txt', $oldf);
$newF = fopen("newfile.txt", 'r+') or die("Unable to open file!");
fseek($newF, 782);
$data = fread($newF, 1740);
$strB = preg_replace('/(wha)/', 'which', $data, -1, $countB);
file_put_contents('newfile.txt', $strB);
fclose($newF);

//Inserts the values into MySQL
$sql_query = "INSERT INTO editing SET preedit='$LookString', postedit='$countA', selection='$countB'";
$result = mysqli_query($link, $sql_query) or die('query failed'. mysqli_error($link));

//Closes MySQL connection
mysqli_close($link);

?>