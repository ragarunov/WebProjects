<html>
 <head><title>Lab 3</title></head>
 <body>
<?php

$zip = $_POST['zip'];
$match_zip = "/^\ *[a-zA-Z][0-9][a-zA-Z]\ {0,1}[0-9][a-zA-Z][0-9]\ *$/";

$code = $_POST['code'];
$match_code = "/^\ *[A-Z][A-Z][A-Z][0-9][0-9][0-9][A-Z]{1,3}\ *$/";

$phone = $_POST['phone'];
$p1 = "[0-9]{3}\-[0-9]{3}\-[0-9]{4}";
$p2 = "[0-9]{3}\ [0-9]{3}\ [0-9]{4}";
$p3 = "[0-9]{3}\ [0-9]{3}\-[0-9]{4}";
$p4 = "[0-9]{10}";
$p5 = "[0-9]{3}\ [0-9]{7}";
$p6 = "\([0-9]{3}\)\ [0-9]{3}\-[0-9]{4}";
$p7 = "\([0-9]{3}\)\ [0-9]{3}\ [0-9]{4}";
$match_phone = "/^\ *($p1)|($p2)|($p3)|($p4)|($p5)|($p6)|($p7)\ *$/";

$errZ = "";
$errS = "";
$errP = "";
$validZ = true;
$validS = true;
$validP = true;

if ($_POST) {
	
	if (!(preg_match($match_zip, $zip)) || !(preg_match($match_code, $code)) || !(preg_match($match_phone, $phone))) {
		
		$errZ = "Invalid ZIP Code";
		$errS = "Invalid Subject Code";
		$errP = "Invalid Phone number";
		if (!(preg_match($match_zip, $zip))) $validZ = false;
		if (!(preg_match($match_code, $code))) $validS = false;
		if (!(preg_match($match_phone, $phone)))$validP = false;
		
?>
<form method="POST" action="">
   Zip Code: <input type="text" name="zip" value="<?php if (isset($zip) && !$valid) echo $zip; ?>"><?php if (!$validZ) echo $errZ; ?><br>
   Subject Code: <input type="text" name="code" value="<?php if (isset($code) && !$valid) echo $code; ?>"><?php if (!$validS) echo $errS; ?><br>
   Phone Code: <input type="text" name="phone" value="<?php if (isset($phone) && !$valid) echo $phone; ?>"><?php if (!$validP) echo $errP; ?><br>
  <input type="submit" value="Test">
</form>
<br />
<br />

<?php

	}

	else {
		
		echo "$zip is valid!<br />";
		echo "$code is valid!<br />";
		echo "$phone is valid!<br />";
		
	}
	
}

else {

?>

<form method="POST" action="">
   Zip Code: <input type="text" name="zip"><br>
   Subject Code: <input type="text" name="code"><br>
   Phone Code: <input type="text" name="phone"><br>
  <input type="submit" value="Register">
</form>
<br />
<br />
	
<?php
	
}

?>

 </body>
 </html>