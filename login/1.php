<?php
	session_start();
	$_SESSION['login'] = 1;
	//$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
	echo $_SESSION['count']; 
?>