<?php
	session_start();
	include("connection.php");

	$userid = stripslashes(htmlspecialchars($_GET['userid']));	

	$result = mysqli_prepare($link,("SELECT a.id, case when b.userID = '{$userid}' then b.pairedUserID else b.userID end outUserID FROM chats a, jobs b WHERE a.jobID = b.jobID AND (b.userID = '{$userid}' OR b.pairedUserID = '{$userid}');"));
	$result->execute();

	$result = $result->get_result();
	while ($r = $result->fetch_row()) {
		echo $r[0];
		echo "\\";
		echo $r[1];
		echo "\n";
	}
?>