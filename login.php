<?php
session_start();
include("connection.php");   
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$email_err = $password_err = "";
	$email = $mypassword = "";


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

	if(empty($email_err) && empty($password_err)) {
		$sql = "SELECT userID,email,password,userType FROM user WHERE email = ?";

		if($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_email);
		}

		$param_email = $myemail;

		if(mysqli_stmt_execute($stmt)) {
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $userID, $myemail, $hashed_password, $userType);

				if(mysqli_stmt_fetch($stmt)) {
					if(password_verify($mypassword, $hashed_password)) {
						$_SESSION['userID'] = $userID;
						$_SESSION['login_user'] = $myemail;
						$_SESSION['userType'] = $userType;
						header("location: index.php");
					}
					else {
						$password_err = "The password entered was not valid";
						$_SESSION['Message'] = urlencode($password_err);
						header("location: CreateAccount.php");
						echo $password_err;
					} 
				}
			}
			else {
				$email_err = "There is no account with that email";
				header("location: CreateAccount.php");
				echo $email_err;
			}
		}
		else {
			echo "Something has gone wrong";
		}
	}


	mysqli_close($link);
}
?>

