<?php
// Session start and connection file inclusion
session_start();
include("connection.php");   
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Set variable(s) for this page 
	$complete = $_POST['complete'];
	$cancel = $_POST['cancel'];
	
	if(!empty($complete)) {
		$jobID = $complete;
	} elseif(!empty($cancel)) {
		$jobID = $cancel;
	} else {
		header("location: User.php");
	}
	
	// Create the mySQL code to be run in the database
	$insertJob = "INSERT INTO jobs_history SELECT * FROM jobs WHERE jobID = \"{$jobID}\";";
	if($iJob = mysqli_prepare($link, $insertJob)) {
		mysqli_stmt_execute($iJob);
	}
	
	$deleteJob = "DELETE FROM jobs WHERE jobID = \"{$jobID}\";";
	if($dJob = mysqli_prepare($link, $deleteJob)) {
		mysqli_stmt_execute($dJob);
	}
	
	mysqli_close($link);
	header("location: User.php");
}
?>
