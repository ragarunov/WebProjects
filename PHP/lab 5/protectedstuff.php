<?php
session_start();

if(!isset($_SESSION['login'])) {
	
	header("location:login.php");

}

else {
	
	$out = $_GET['logout'];
	
	if (isset($out)) {
		
		unset($_SESSION["login"]);
		session_destroy();
		setcookie("PHPSESSID", "", time() - 3600,  "/");
		header("location:login.php");
		
	}
	
?>
<html>
 <head><title>Lab 5 - Protected</title></head>
 <body>
 <?php echo "You are logged in!"; ?>
	<br /><br /><a href="?logout">Logout</a>
 </body>
</html>
<?php
	
}

?>