<?php
// Session start and connection file inclusion
session_start();
include("connection.php");

// If the page was opened as a post method then perform code
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Setup variables to be used
	$jobID = $_POST['claim'];
	$userID = $_SESSION['userID'];
	$jobID_err = "";
	
	// Check if the POST field(s) is empty
	if(empty($jobID)) {
		$jobID_err = "No jobID given.";
	}
	
	// Check job is still in range
	
	
	// Check job exists in the `jobs` table
	$getJob = "SELECT * FROM jobs WHERE jobID = \"{$jobID}\";";
	$returnedJob = mysqli_query($link, $getJob);
	
	if (empty($returnedJob)) {
		$_SESSION['overlayCheck'] = "There was an issue claiming that job.";
		header("location: index.php");
	} else {
		unset($_SESSION['overlayCheck']);
	}
	
	// Create mySQL statement to update the database
	$stmt = "UPDATE jobs SET pairedUserID = \"{$userID}\", isApproved = 1 WHERE jobID = {$jobID};";
	$stmt2 = "INSERT INTO chats (jobID) VALUES ({$jobID});";

	if($update = mysqli_prepare($link, $stmt)) {
		mysqli_stmt_execute($update);
	}
	if($insert = mysqli_prepare($link, $stmt2)) {
		mysqli_stmt_execute($insert);
	}
	header("location: index.php");
	mysqli_close($link);
}
?>

