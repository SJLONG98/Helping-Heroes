<?php
	session_start();
	include("connection.php");

	$userid = stripslashes(htmlspecialchars($_GET['userid']));
	$chatid = stripslashes(htmlspecialchars($_GET['chatid']));
	$message = stripslashes(htmlspecialchars($_GET['message']));
	
	
	$result = mysqli_prepare($link,("INSERT INTO messages (chatId,userId,message) VALUES ({$chatid},'{$userid}','{$message}');"));
	$result->execute();
?>