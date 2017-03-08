<?php

session_start();
 
//Connect to SQL Server
require "myClass.php";
$db = new DBLink("int322_163c17");

$user = $_POST['username'];
$pass = $_POST['password'];
$hash = crypt($pass);
$forgot = $_GET['forgot'];
$error = false;
$yes = false;

if (!isset($forgot)) {

	if ($_POST) {
	
		$get = $db->query("SELECT * from users WHERE username='$user'");
		$check = $db->row($get);
	
		$r = mysqli_fetch_assoc($get);
		
		//http://stackoverflow.com/questions/3135524/comparing-passwords-with-crypt-in-php
		
		if ($check == 1) {
		
			if (crypt($pass, $r['password']) == $r['password']) {
			
				$log = "<font color='#FF0000'><i><u>You're logged in!</u></i></font><br />";
				$yes = true;
		
			}
		
			else {
		
				$err = "<font color='#FF0000'><i><u>Invalid username or password</u></i></font><br />";
				$error = true;
		
			}
		
		}
	
	}

?>

<html>
 <head><title>Lab 6 - Login</title></head>
 <body>
 <form method="POST" action="">
   Username: <input type="text" name="username" value=""><br />
   Password: <input type="password" name="password" value=""><br />
   <br />
  <input type="submit" value="Login">
</form><?php if ($error) echo $err; else if ($yes) echo $log; ?><br />
<b><a href="?forgot">Forgot your password?</a></b>

<?php

}

else {

$em = $_POST['email'];

	if (isset($em)) {
		
		$get = $db->query("SELECT * from users WHERE username='$em'");
		
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

?>
 </body>
 </html>