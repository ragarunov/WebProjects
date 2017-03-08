<?php
session_start();

if(!isset($_SESSION['login'])) {
	
	header("location:login.php");

}

else {

	echo $_SESSION['login'];
	
}

?>