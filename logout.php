<?php
session_start();

if(!isset($_SESSION["user_id"])){
	header("Location: ./index.php");
	die();
}

session_unset(); 
session_destroy();
$done = 'You have Logged out Successfully';
header("location: ./index.php?done=$done");
mysqli_close($conn);
die();

?>