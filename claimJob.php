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
	
	// Create mySQL statement to update the database
	$stmt = "UPDATE jobs SET pairedUserID = \"{$userID}\" WHERE jobID = {$jobID};";

	if($update = mysqli_prepare($link, $stmt)) {
		mysqli_stmt_execute($update);
	}
	header("location: index.php");
	mysqli_close($link);
}
?>

