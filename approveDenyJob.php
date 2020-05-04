<?php
// Session start and connection file inclusion
session_start();
include("connection.php");   
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Set variable(s) for this page 
	$approve = $_POST['approve'];
	$deny = $_POST['deny'];
	
	if(!empty($approve)) {
		$approvalKey = 1;
		$jobID = $approve;
	} elseif(!empty($approve)) {
		$approvalKey = 0;
		$jobID = $deny;
	} else {
		header("location: AdminLists.php");
	}
	
	// Create the mySQL code to be run in the database
	$stmt = "UPDATE jobs SET isApproved = \"{$approvalKey}\" WHERE jobID = {$jobID};";

		if($update = mysqli_prepare($link, $stmt)) {
			mysqli_stmt_execute($update);
		}
		mysqli_close($link);
		header("location: AdminLists.php");
		
}
?>
