<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
	}


?>

<!DOCTYPE html>
<html>
	<head>
		<!-- The head section currently contains details to make the software viewable
				Further changes are needed for the final version -->
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" href="images/Hlogo.png" type="image/png" sizes="16x16">
		<title>Password Reset</title>
	</head>
	<?php
	include("Navbar.php");
	?>
		<main>
			<div class="container-fluid text-center">
				<h1> Reset your password</h1>
				<p> An Email will be sent to you with insuructions on how to reset your password</p>
					<form action="sendEmail.php" method="post">
						<input type="text" name="email" placeholder="Enter your Email...">
						<input type="submit" name="ResetPassword" value="Reset">
						</form>
				<?php

				if (isset($_GET["reset"])) {
					if ($_GET["reset"] == "success") {
						echo '<p class"signupsuccess"> Check Your Email</p>';
					}
				}
				?>
				
			</div>
		</main>
	<body>

		
		
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>