<?php
 
$name = $_POST['name'];
$val = $_POST['val'];

$visit = 0;

setcookie($name, $val);

if (!isset($_COOKIE['count'])) {
	
	$visit = 1;
	setcookie("count", $visit);
	echo "This is your first visit in this page";
	
}

else {
	
	$visit = ++$_COOKIE['count'];
	setcookie("count", $visit);
	echo "Welcome back -  you visited this page ";
	echo $_COOKIE['count'];
	echo " times.<br /><br />";

}

$nerr = "";
$verr = "";

$valid = true;

if ($_POST) {
	
	if ($name == "") {
		
		$nerr = "Name must include at least one field";
		$valid = false;
		
	}
	
	if ($val == "") {
		
		$verr = "Value must include at least one field";
		$valid = false;
		
	}
	
}

?>
<html>
 <head><title>Lab 5 - Cookies</title></head>
 <body>
 <form method="POST" action="">
   Cookie Name: <input type="text" name="name" value="<?php if (isset($name)) echo $name; ?>"><?php if (!$valid) echo $nerr; ?><br>
   Cookie Value: <input type="text" name="val" value="<?php if (isset($val)) echo $val; ?>"><?php if (!$valid) echo $verr; ?> <br>
   <br />
  <input type="submit" value="Register">
</form>

<?php

echo "Cookies on the server are: <br />";

$line = 1;

foreach ($_COOKIE as $key => $val) {
	
	echo $line.') '.$key.' is '.$val."<br>\n";
	$line++;
	
}

?>
 </body>
 </html>