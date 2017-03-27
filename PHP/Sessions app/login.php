<?php

session_start();
 
//Connect to SQL Server
$lines = file('/home/int322_163c17/secret/topsecret.txt');
$dbserver = trim($lines[0]);
$uid = trim($lines[1]);
$pw = trim($lines[2]);
$dbname = trim($lines[3]);

$link = mysqli_connect($dbserver, $uid, $pw, $dbname) or die('Could not connect: ' . mysqli_error($link));

$user = $_POST['username'];
$pass = $_POST['password'];
$forgot = $_GET['forgot'];
$error = false;

if (!isset($forgot)) {

	if ($_POST) {
	
		$get = mysqli_query($link, "SELECT * from users WHERE username='$user' AND password ='$pass'") or die('query failed'. mysqli_error($link));
	
		$r = mysqli_fetch_assoc($get);
		
		if (mysqli_num_rows($get)) {
		
			$_SESSION['login'] = $user;
			header("location:protectedstuff.php");
		
		}
		
		else {
		
			$err = "<font color='#FF0000'><i><u>Invalid username or password</u></i></font><br />";
			$error = true;
		
		}
	
	}

?>

<html>
 <head><title>Lab 5 - Login</title></head>
 <body>
 <form method="POST" action="">
   Username: <input type="text" name="username" value=""><br />
   Password: <input type="password" name="password" value=""><br />
   <br />
  <input type="submit" value="Login">
</form><?php if ($error) echo $err; ?><br />
<b><a href="?forgot">Forgot your password?</a></b>

<?php

}

else {

$em = $_POST['email'];

	if (isset($em)) {
		
		$get = mysqli_query($link, "SELECT * from users WHERE username='$em'") or die('query failed'. mysqli_error($link));
		
		$r = mysqli_fetch_assoc($get);
		$u = $r['username'];
		$h = $r['passwordHint'];
		$msg = "Username: $u\nHint: $h";
		
		if (mysqli_num_rows($get)) {
			
			mail($em, "Password Recovery", $msg, "From: Ronen <ragarunov@myseneca.ca>\r\nReply-to: Ronen <ragarunov@myseneca.ca>");
			header("location:protectedstuff.php");
		
		}
		
		else {
		
			header("location:protectedstuff.php");
		
		}
		
	}
	
?>

<form method="POST" action="">
  Please enter your email address: <input type="text" name="email" value=""><br />
   <br />
  <input type="submit" value="Send">
</form>

<?php
	
}

mysqli_close($link);

?>
 </body>
 </html>