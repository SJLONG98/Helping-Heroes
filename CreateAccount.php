<?php
	session_start();
	include("connection.php");

	$userID = $email = $userType = $password = $confirm_password = $secQuestion = $secAnswer = "";
	$userID_err = $email_err = $userType_err = $password_err = $confirm_password_err = $secQuestion_err = $secAnswer_err = "";

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if(empty(trim($_POST["userID"]))) {
			$userID_err = "Please enter a username.";
		} else {
			$userID = trim($_POST["userID"]);
		}

		if(empty(trim($_POST["email"]))) {
			$email_err = "Please enter an email.";
		} else {
			$sql = "SELECT * From users WHERE EMAIL = ?";
			if($stmt = mysqli_prepare($link, $sql)) {
				mysqli_stmt_bind_param($stmt,"s",$param_email);
				$param_email = trim($_POST["email"]);

				if(mysqli_stmt_execute($stmt)) {
					mysqli_stmt_store_result($stmt);

					if(mysqli_stmt_num_rows($stmt) == 1) {
						$email_err = "There is already an account with this email.";
					}
					else {
						$email = trim($_POST["email"]);
					}
				} else {
					echo "Something has gone wrong";
				}
			}
			mysqli_stmt_close($stmt);
		}
		
		if(empty(trim($_POST["userType"]))) {
			$userType_err = "Please select your role.";
		} else {
			$userType = trim($_POST["userType"]);
		}

		if(empty(trim($_POST['password']))){
			$password_err = "Please enter a password.";     
		} elseif(strlen(trim($_POST['password']))< 6){
			$password_err = "Password must have at least 6 characters.";
		} else{
			$password = trim($_POST['password']);
		}

		if(empty(trim($_POST["confirmPassword"]))){
			$confirm_password_err = 'Please confirm password.';     
		} else{
			$confirm_password = trim($_POST['confirmPassword']);
			if($password != $confirm_password){
				$confirm_password_err = 'Password did not match.';
			}
		}

		if(empty($userID_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
			$addUser = "INSERT INTO USERS (USERNAME, FNAME, SNAME, EMAIL, PASSWORD) VALUES (?, ?, ?, ?, ?)";

			if($add = mysqli_prepare($link, $addUser)) {
				mysqli_stmt_bind_param($add, "sssss", $param_uname, $param_fname, $param_sname, $param_email, $param_password);
				$param_uname = $uname;
				$param_fname = $fname;
				$param_sname = $sname;
				$param_email = $email;
				$param_password = password_hash($password, PASSWORD_DEFAULT);
				if(mysqli_stmt_execute($add)) {
					header("location: CreateAccount.php");
				}
				else {
					echo $add->error;
				}
			}
		}
		mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="icon" href="#"/>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Helping Heroes: Account</title>
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	</head>
	<body>
		<?php 
		if(isset($_SESSION['login_user'])){
			include("LoggedInNavBar.php");
		}
		else {
			include("LoginNavBar.php");
		}
		?>
		<div id="site_content">
			<div id="content">
				<h2>Create Account</h2>
				<h4>Please fill out the following fields and press submit to create your account.</h4>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div>
						<label for="username">Username</label>
						<br>
						<input type="text" id="uname" name="uname" placeholder=" JohnSmith95">
						<?php if (empty($userID_err)) { 
								} else { ?>
						<p><?php echo $userID_err; ?></p>
						<?php } ?>
					</div>

					<div>
						<label for="email">Email Address</label>
						<br>
						<input type="text" id="email" name="email" placeholder=" johnsmith1995@gmail.com">
						<?php if (empty($email_err)) { 
								} else { ?>
						<p><?php echo $email_err; ?></p>
						<?php } ?>
					</div>
					
					<div>
						<label for="userType">User Type</label>
						<br>
							<select type="text" id="userType" name="userType">
								<option value="">Please choose a role...</option>
								<option value="2">Volunteer</option>
								<option value="3">Key Worker</option>
							</select>
					</div>
					
					<div>
						<label for="password">Password</label>
						<br>
						<input type="text" id="password" name="password" placeholder="">
						<?php if (empty($uname_err)) { 
								} else { ?>
						<p><?php echo $password_err; ?></p>
						<?php } ?>
					</div>

					<div>
						<label for="confirmPassword">Confirm Password</label>
						<br>
						<input type="text" id="confirmPassword" name="confirmPassword" placeholder="">
						<?php if (empty($uname_err)) { 
								} else { ?>
						<p><?php echo $confirm_password_err; ?></p>
						<?php } ?>
					</div>
					
					<div>
						<label for="secQuestion">Security Question</label>
						<br>
							<select type="text" id="secQuestion" name="secQuestion">
								<option value="">Please choose a question...</option>
								<option value="1">What was your first pet's name?</option>
								<option value="2">What is your favourite colour?</option>
								<option value="3">Where was your first holiday?</option>
							</select>
					</div>
					
					<div>
						<label for="secAnswer">Security Answer</label>
						<br>
						<input type="text" id="secAnswer" name="secAnswer" placeholder="">
						<?php if (empty($secAnswer_err)) { 
								} else { ?>
						<p><?php echo $secAnswer_err; ?></p>
						<?php } ?>
					</div>
					
					<br>
					<input type="submit" value="Register">    
				</form>
			</div>
			<div class="content">
				<h2>Login</h2>
				<h4>Please enter your email and password to login.</h4>
				<form action ="login.php" method = "post">
					<div>
						<label for="email">Email</label>
						<br>
						<input type="email" name="email" placeholder="Email">
					</div>

					<div>
						<label for="password">Password</label>
						<br>
						<input type="password" name="password" placeholder="Password">
						<?php if(isset($_SESSION['Message'])){ ?>
							<p> <?php echo str_replace('+',' ',$_SESSION['Message']);?> </p>
						<?php unset($_SESSION['Message']); } ?>
					</div>

					<input type="submit" name="submit" value="Login" id="login" onclick="loginFunction()">
				</form>
			</div>
		</div>
	</body>
</html>