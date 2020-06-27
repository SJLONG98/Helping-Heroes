<?php
// Session start and connection file inclusion
session_start();
include("connection.php");  

// If the page was opened as a post method then perform code
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Setup variables for the code to use
	$email_err = $password_err = "";
	$email = $mypassword = "";

	// Make error message checks
	if(empty(trim($_POST["email"]))) {
		$email_err = "Please enter an email";
	}
	else {
		$myemail = $_POST['email'];
	}

	if(empty(trim($_POST["password"]))) {
		$password_err = "Please enter a password";
	}
	else {
		$mypassword = $_POST['password'];
	}
	
	// If there were no errors then attempt main login process
	if(empty($email_err) && empty($password_err)) {
		
		// Build script to be run in mySQL
		$sql = "SELECT userID,email,password,userType FROM users WHERE email = ?";

		if($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_email);
		}

		$param_email = $myemail;

		if(mysqli_stmt_execute($stmt)) {
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $userID, $myemail, $hashed_password, $userType);
				
				// Check hashed new password entered vs stored hashed password
				if(mysqli_stmt_fetch($stmt)) {
					if(password_verify($mypassword, $hashed_password)) {
						$_SESSION['userID'] = $userID;
						$_SESSION['login_user'] = $myemail;
						$_SESSION['userType'] = $userType;
						header("location: index.php");
					}
					else {
						// If the password is wrong output the relevant error
						$password_err = "The password entered was not valid";
						$_SESSION['Message'] = urlencode($password_err);
						header("location: CreateAccount.php");
						echo $password_err;
					} 
				}
			}
			else {
				// If the email doesn't exist output the relevant error
				$email_err = "There is no account with that email";
				$_SESSION['Message'] = urlencode($email_err);
				header("location: CreateAccount.php");
				echo $email_err;
			}
		}
		else {
			echo "Something has gone wrong";
		}
	}
	
	header("location: index.php");
	mysqli_close($link);
}
// Otherwise do nothing
?>

