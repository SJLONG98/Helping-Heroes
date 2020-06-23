<?php
	// Session start, check user access to this page and inclusion of connection file
	session_start();
	
	if(!isset($_SESSION["login_user"])) {
		header("location: index.php");
	}
	include("connection.php"); 
	
	// Setting page variables to be used in the code
	$userID = $_SESSION['userID'];
	$userType = $_SESSION['userType'];
	$email = $_SESSION['login_user'];

	$address = $phoneNumber = $postcode = $dob = "";
	$address_err = $phoneNumber_err = $postcode_err = $dob_err = "";
	
	$status = "";
	
	// mySQL code run to get this user's current vetting status
	$getStatus = "SELECT isVetted, vettingFileName, dob FROM user WHERE userID = \"{$userID}\"";
	$result = mysqli_query($link, $getStatus);
	$row = mysqli_fetch_array($result);
	if($row[0] == 0 && (!empty($row[0]))) {
		$status = "Denied";
	} elseif($row[0] == 1) {
		$status = "Approved";
	} else {
		$status = "Not Approved";
	}
	
	if (!empty($row[1])) {
		$hasUploaded = 1;
		$fileURL = "helpingheroes/".$row[1];
	} else {
		$hasUploaded = 0;
	}
	
	if (!empty($row[2])) {
		$userDOB = $row[2];
	} else {
		$userDOB = "1990-01-01";
	}
	

// If the server method from a form is POST then run this code
//  to update the users account based on form fields filled in
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$address = trim($_POST["address"]);
	$postcode = trim($_POST["postcode"]);
	$phoneNumber = trim($_POST["phoneNumber"]);
	$dob = trim($_POST["dob"]);
	$updateAccount = "UPDATE user SET";

	if(!empty($address)) {$updateAccount .= " address = \"{$address}\",";};

	if(!empty($postcode)) {$updateAccount .= " postcode = \"{$postcode}\",";};

	if(!empty($phoneNumber)) {$updateAccount .= " phoneNumber = \"{$phoneNumber}\",";};

	if(!empty($dob)) {$updateAccount .= " dob = \"{$dob}\" ";}
	
	if($updateAccount != "UPDATE user SET") {
		$updateAccount = substr($updateAccount ,0,-1);
		$updateAccount .= " WHERE userID = \"{$userID}\"";
	}

	if(!empty($updateAccount) && !($updateAccount == "UPDATE user SET")) {

		if($update = mysqli_prepare($link, $updateAccount)) {
			if(mysqli_stmt_execute($update)) {
				header("location: User.php");
			}
			else {
				echo $update->error;
			}
		}
	}
	
	echo $updateAccount;


}
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- The head section currently contains details to make the software viewable
				Further changes are needed for the final version -->
		<link rel="icon" href="#"/>
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Edit Account</title>
		<meta http-equiv="content-type" content="text/html; charset=windows-1252" />
	</head>
	<body>
		<?php 
		// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div class="container-fluid text-center">
			<div class="row content">
				<div class="col-sm-2 sidenav"></div>
				<div class="col-sm-3">
					<h2>Update Account</h2>
					<h4>Please fill out the following fields and press submit to update your account.</h4>
					<h4>Note: Any fields left blank will not be changed.</h4>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div>
							<label for="userID">Username</label>
							<br>
							<input type="text" id="userID" name="userID" placeholder=" <?php echo $userID; ?>" readonly>
							<?php if (empty($userID_err)) { 
									} else { ?>
							<p><?php echo $userID_err; ?></p>
							<?php } ?>
						</div>

						<div>
							<label for="email">Email Address</label>
							<br>
							<input type="text" id="email" name="email" placeholder=" <?php echo $email; ?>" readonly>
							<?php if (empty($email_err)) { 
									} else { ?>
							<p><?php echo $email_err; ?></p>
							<?php } ?>
						</div>
						
						<div>
							<label for="address">Home Address</label>
							<br>
							<input type="text" id="address" name="address" placeholder=" ">
							<?php if (empty($address_err)) { 
									} else { ?>
							<p><?php echo $address_err; ?></p>
							<?php } ?>
						</div>
						
						<div>
							<label for="postcode">Postcode</label>
							<br>
							<input type="text" id="postcode" onkeyup="validatePostcode()" name="postcode" placeholder=" ">
							<?php if (empty($postcode_err)) { 
									} else { ?>
							<p><?php echo $postcode_err; ?></p>
							<?php } ?>
						</div>
						
						<div>
							<label for="phoneNumber">Phone Number</label>
							<br>
							<input type="text" id="phoneNumber" name="phoneNumber" placeholder=" ">
							<?php if (empty($phoneNumber_err)) { 
									} else { ?>
							<p><?php echo $phoneNumber_err; ?></p>
							<?php } ?>
						</div>
						
						<div>
							<label for="dob">Date of Birth</label>
							<br>
							<input type="date" name="dob" min="1900-01-01" max="2002-01-01" value="<?php echo $userDOB; ?>">
							<?php if (empty($dob_err)) { 
									} else { ?>
							<p><?php echo $dob_err; ?></p>
							<?php } ?>
						</div>
						
						<br>
						<input id="updateButton" type="submit" value="Update">    
					</form>
				</div>
				<div class="col-sm-2 sidenav"></div>
				<div class="col-sm-3">
					<!-- This div contains the current verified status of the user
							as well as a form to upload a file to be used as verification.-->
					<h2>Verified Status</h2>
					<p>Please upload a pfd file to be vetted.</p>
					<h4><?php echo $status; ?></h4>
					<?php if ($hasUploaded == 0 && $status != "Approved") {?>
						<form action="uploadFile.php" method="post" enctype="multipart/form-data">
							Select file to upload for approval:
							<input type="file" name="fileToUpload" id="fileToUpload" accept=".pdf">
							<br>
							<input type="submit" value="Add File" name="submit">
					</form>
					<?php } elseif ($status == "Not Approved") {?>
						<iframe src="<?php echo $fileURL; ?>" height="500" width="400"></iframe>
					<?php } else { ?>
					<?php }; ?>
				</div>
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		
		<script type="text/javascript">
			function validatePostcode() {
				const http = new XMLHttpRequest();
				var apiGetString, input, x;
				
				x = document.getElementById("updateButton");
				
				apiGetString = "https://api.postcodes.io/postcodes/";
				input = document.getElementById("postcode");
				toCheck = input.value.toUpperCase();
				
				apiGetString = apiGetString.concat(toCheck,"/validate");
				
				x.disabled = false;
				if (apiGetString != "https://api.postcodes.io/postcodes//validate") {
					
					http.open("GET", apiGetString, false);
					http.send();

					if (http.responseText.match(/false/i)) {
						x.disabled = true;
					}
				}
			}
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>