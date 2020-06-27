<html>
	<head>
		<style>
	.navbar-inverse .navbar-toggle {
			border-color: gray;
			color: black;
			}
	.navbar-toggle {
    		background-color: gray;
			}
	.navbar-inverse .navbar-nav>li>a {
    	color: black;
			}
	.navbar-inverse .navbar-nav > li > a:hover,
	.navbar-inverse .navbar-nav > li > a:focus {
		color: gray;
		background-color: transparent;
			}


		</style>
	</head>
</html>
<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include_once("connection.php");
	
	// If the user is logged in set up user variables to be used 
	//  and log which type of user they are
	if (isset($_SESSION['login_user'])){
		
		$sql = "SELECT userType, isVetted FROM users WHERE email = ?";

		if($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_email);
		}

		$param_email = $_SESSION['login_user'];

		if(mysqli_stmt_execute($stmt)) {
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $uType, $iVetted);
				mysqli_stmt_fetch($stmt);
				$_SESSION['userType'] = $uType;
			}
		}
		
		if ($_SESSION['userType'] == 1) {
			$userType = "Admin";
		} elseif ($_SESSION['userType'] == 2) {
			$userType = "Volunteer";
		} elseif ($_SESSION['userType'] == 3) {
			$userType = "Key Worker";
		}
		
		$isVetted = $iVetted;
		$_SESSION['isVetted'] = $isVetted;
	}
	
?>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Helping Heroes</a>
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php 
				if (isset($_SESSION['userType'])) {
				if($userType == "Admin") {} else if ($userType == "Volunteer" && $isVetted == 1) { ?> <li><a href="CreateRequest.php">Create Offer</a></li> <?php } elseif ($userType == "Key Worker" && $isVetted == 1) { ?> <li><a href="CreateRequest.php">Create Request</a></li> <?php };
				if($userType == "Admin") { ?> <li><a href="Admin.php"><span class="logo_colour">Admin</span></a></li> <?php } else { ?> <li><a href="User.php">Profile</a></li>  <?php }; ?> 
				<li><a href="Messages.php">Messages</a></li>
				<li><a href="logout.php" onclick="callFunction(this.href);return false;">Logout</a></li> <?php
				} else { ?>
				<li><a href="CreateAccount.php">Login / Create Account</a></li>
				<?php }; ?>
			</ul>
		</div>
	</div>
</nav>
