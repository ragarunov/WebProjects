<html>
	<head>
		<title> Assignment 1 </title>
	</head>
	
	<body>
	
<?php

/*
// Ronen Agarunov
// Student I.D: 029-490-158
// Zenit login: int322_163c17
// INT322 - c 17
*/

//sets timezone to Toronto {EST}
date_default_timezone_set('America/Toronto');

//assigns form variables an easier name {convenience purposes}
$modelname = $_POST['model'];
$min = $_POST['min'];
$max = $_POST['max'];

//Errors
$modelerr = "";
$minerr = "";
$maxerr = "";
$valid = true;

//Connect to SQL Server
$lines = file('/home/int322_163c17/secret/topsecret.txt');
$dbserver = trim($lines[0]);
$uid = trim($lines[1]);
$pw = trim($lines[2]);
$dbname = trim($lines[3]);

$link = mysqli_connect($dbserver, $uid, $pw, $dbname) or die('Could not connect: ' . mysqli_error($link));

//Empties table to prevent an overload on the database each time form is refreshed
$clear =  mysqli_query($link, 'TRUNCATE TABLE product') or die('query failed'. mysqli_error($link));

//Reads data from the files into arrays
$model = file('cellphone.txt');
$os = file('OS.txt');
$version = file('version.txt');
$price = file('price.txt');

//A loop that runs through each array of data and populates the database
for ($i = 0; $i < count($model); $i++) {

	$in = "INSERT INTO product SET model='$model[$i]', os='$os[$i]', version='$version[$i]', price='$price[$i]'";
	$result = mysqli_query($link, $in) or die('query failed'. mysqli_error($link));
	
}

//Validation of the form before processing the information
if ($_POST) {
	
	if ($_POST['model'] == "none") {
		
		$modelerr = " Must choose a product!";
		$valid = false;
		
	}
	
	if (!(is_float($_POST['min']+0))) {
		
		$minerr = " Minimum number must be numeric";
		$valid = false;
		
	}
		
	if (!(is_float($_POST['max']+0))) {
		
		$maxerr = " Maximum number must be numeric";
		$valid = false;
		
	}
	
	if ($min > $max) {
		
		$maxerr = " Minimum price cannot be higher than maximum";
		$valid = false;
		
	}
	
}

?>

	 <form method="POST" action="">
		<select name="model">
			<option name="none" value="none">--Please choose--</option>
<?php

//                       * Samsung  Galaxy will print only once so there will be only 5 entries in the drop menu instead of 6 *
$get = mysqli_query($link, 'SELECT DISTINCT model from product') or die('query failed'. mysqli_error($link));

//A loop that populates the dropmenu in the form with all the model names existing in the database
while ($r = mysqli_fetch_assoc($get)) {
	
?>
	
			<option name="<?php print $r['model']; ?>" value="<?php print $r['model']; ?>"<?php if ($_POST['model'] == $r['model']) echo "SELECTED"; ?>><?php echo $r['model']; ?></option>
			
<?php
			
}

?>
	</select><?php if (!$valid) echo $modelerr; ?>
		<br />
		<b>Minimum Price</b> <input type="text" name="min" value="<?php if (isset($min)) echo $min; else echo ".00"; ?>"><?php if (!$valid) echo $minerr; ?><br />
		<b>Maximum Price</b> <input type="text" name="max" value="<?php if (isset($max)) echo $max; else echo ".00"; ?>"><?php if (!$valid) echo $maxerr; ?>
		<br />
		<input type="submit" value="Search">
	 </form>
	
	
<?php

//If form is submitted and all data is valid then start processing data
if ($_POST && $valid) {
	
?>

	<table border="1">
	<caption><b>These are all the phones that fit your price range and your <u>selected model</u></b></caption>
		<tr>
			<th>Model</th>
			<th>Version</th>
			<th>OS</th>
			<th>Price</th>
		</tr>
		
<?php

	$get = mysqli_query($link, "SELECT * from product WHERE model = '$modelname' AND price <= '$max' AND price >= '$min' ORDER BY price") or die('query failed'. mysqli_error($link));

	//prints a table with all the records that fit the price range entered AND the model selected
	if (mysqli_num_rows($get)) {
		
		while ($r = mysqli_fetch_assoc($get)) {
		
?>

		<tr>
			<td><?php print $r['model']; ?></td>
			<td><?php print $r['version']; ?></td>
			<td><?php print $r['os']; ?></td>
			<td><?php print '$'. $r['price']; ?></td>
		</tr>
		
<?php
	
		}
		
	}
	
	else {
		
		echo "<tr>";
			echo "<td colspan='4'>";
				echo "No results match the model and price range entered";
			echo "</td>";
		echo "</tr>";
		
	}

	//Prints date and time the form results have been printed
?>
		
	</table>
	<br />
	<br />
	<table border="1">
	<caption><b>These are all the phones that fit your price range</b></caption>
		<tr>
			<th>Model</th>
			<th>Version</th>
			<th>OS</th>
			<th>Price</th>
		</tr>
		
<?php
	
	$get = mysqli_query($link, "SELECT * from product WHERE price <= '$max' AND price >= '$min' ORDER BY price") or die('query failed'. mysqli_error($link));
	
	//prints a table with all the records that fit the price range entered
	if (mysqli_num_rows($get)) {
		
		while ($r = mysqli_fetch_assoc($get)) {
		
?>

		<tr>
			<td><?php print $r['model']; ?></td>
			<td><?php print $r['version']; ?></td>
			<td><?php print $r['os']; ?></td>
			<td><?php print '$'. $r['price']; ?></td>
		</tr>
		
<?php
		
		}
		
	}
	
	else {
		
		echo "<tr>";
			echo "<td colspan='4'>";
				echo "No results match price range entered";
			echo "</td>";
		echo "</tr>";
		
	}
	
?>

	</table>
	<br />
	<i>Query printed in: <?php print date("d/m/y h:i:s a"); ?></i>
	
<?php
	
}

//Closes MySQL connection
mysqli_close($link);

?>
	
	</body>
</html>