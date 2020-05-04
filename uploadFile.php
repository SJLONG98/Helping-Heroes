<?php
// Session start and connection file inclusion
session_start();
include("connection.php");

// If the page was opened as a post method then perform code
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Set variable(s) for this page
	$userID = $_SESSION['userID'];
	
	// Setup and check that the file passed in can be uploaded to the server
	$target_dir = "helpingheroes/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	echo $target_file;
	$uploadOk = 1;
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if the file passed is the right type (pdf files)
	if($fileType != "pdf") {
		$image_err = "Sorry, only PDF files are allowed.";
		$uploadOk = 0;
	}
	// If the file can be uploaded then attempt the upload
	if ($uploadOk == 0) {
	} else {
		echo $_FILES["fileToUpload"]["tmp_name"];
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$file = basename( $_FILES["fileToUpload"]["name"]);
			echo "FILE=".$file;
		} else {
			// If the file can't be uploaded then return to edit account page
			echo "Sorry, there was an error uploading your file.";
			header("location: EditAccount.php");
		}
	}

	// Create the mySQL code to be run in the database
	$updateFile = "UPDATE user SET vettingFileName = ? WHERE userID = ?";

	// If the code it valid then run it with the file and userID parameters
	//  and return to the edit account page
	if($update = mysqli_prepare($link, $updateFile)) {
		mysqli_stmt_bind_param($update, "ss", $param_file, $param_userID);
		$param_file = $file;
		$param_userID = $userID;
		if(mysqli_stmt_execute($update)) {
			header("location: EditAccount.php");
		}
		else {
			echo $update->error;
		}
	}
	mysqli_close($link);
	header("location: EditAccount.php");
}
// Otherwise do nothing
?>

