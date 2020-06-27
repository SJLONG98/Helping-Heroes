<?php
	session_start();
	include("connection.php");

	$userid = stripslashes(htmlspecialchars($_GET['userid']));
	$chatid = stripslashes(htmlspecialchars($_GET['chatid']));
	

	$result = mysqli_prepare($link,("SELECT userId, message FROM messages WHERE chatId = {$chatid};"));
	$result->execute();

	$result = $result->get_result();
	while ($r = $result->fetch_row()) {
		echo $r[0];
		echo "\\";
		echo $r[1];
		echo "\n";
	}
?>