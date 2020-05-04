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
		
		$sql = "SELECT userType FROM user WHERE email = ?";

		if($stmt = mysqli_prepare($link, $sql)) {
			mysqli_stmt_bind_param($stmt, "s", $param_email);
		}

		$param_email = $_SESSION['login_user'];

		if(mysqli_stmt_execute($stmt)) {
			mysqli_stmt_store_result($stmt);

			if(mysqli_stmt_num_rows($stmt) == 1) {
				mysqli_stmt_bind_result($stmt, $uType);
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
	}
?>

<div id="header">
  <div id="logo">
	<div id="logo_text">
	  <h1><a href="index.php"><span class="logo_colour">Helping Heroes</span></a></h1>
	  <h2>Your chance to give something back to our Heroes.</h2>
	</div>
  </div>
  <div id="menubar">
	<!-- This div contains the code for the navbar buttons that are available for each user type -->
	<ul id="menu">
	  <li><a href="index.php">Home</a></li>
	  <?php 
	  if (isset($_SESSION['userType'])) {
		if($userType == "Admin") {} else if ($userType == "Volunteer") { ?> <li><a href="CreateRequest.php">Create Offer</a></li> <?php } elseif ($userType == "Key Worker") { ?> <li><a href="CreateRequest.php">Create Request</a></li> <?php };
		if($userType == "Admin") { ?> <li><a href="Admin.php"><span class="logo_colour">Admin</span></a></li> <?php } else { ?> <li><a href="User.php">Profile</a></li>  <?php }; ?> 
	  <li><a href="logout.php" onclick="callFunction(this.href);return false;">Logout</a></li> <?php
	  } else { ?>
		  <li><a href="CreateAccount.php">Login / Create Account</a></li>
	  <?php }; ?>
	</ul>
  </div>
</div>
