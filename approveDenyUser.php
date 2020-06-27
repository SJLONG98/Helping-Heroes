<?php
// Session start and connection file inclusion
session_start();
include("connection.php");

// If the page was opened as a post method then perform code
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$approve = $_POST['approve'];
	$deny = $_POST['deny'];
	
	// Set variable(s) for this page
	if(!empty($approve)) {
		$approvalKey = 1;
		$userID = $approve;
	} elseif(!empty($deny)) {
		$approvalKey = 0;
		$userID = $deny;
	} else {
		header("location: Admin.php");
	}
	
	// Create mySQL statement to update the database
	$stmt = "UPDATE users SET isVetted = \"{$approvalKey}\", vettingFileName = null WHERE userID = \"{$userID}\"";

	if($update = mysqli_prepare($link, $stmt)) {
		mysqli_stmt_execute($update);
	}
	mysqli_close($link);
	header("location: Admin.php");
		
}
?>
