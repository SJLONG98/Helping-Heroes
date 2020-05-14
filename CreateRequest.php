<?php
	// Session check and connection file inclusion
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	include_once("connection.php");  

	if (!(isset($_SESSION['isVetted'])) || !(isset($_SESSION['login_user'])) || $_SESSION['isVetted'] != 1) {
		header('Location: index.php');
	}
	
	// Setting page variables to be used in the code
	if($_SESSION['userType'] == 2) {
		$jobTypeLower = 'offer';
		$jobTypeCapital = 'Offer';
		$jobTypeWithPrefix = 'an offer';
	} elseif($_SESSION['userType'] == 3) {
		$jobTypeLower = 'request';
		$jobTypeCapital = 'Request';
		$jobTypeWithPrefix = 'a request';
	}

	$userID = $_SESSION['userID'];
	$userType = $_SESSION['userType'];
	$requestTitle = $requestType = $furtherDetails = $duration = $startDate = "";
	$requestTitle_err = $requestType_err = $furtherDetails_err = $duration_err = $startDate_err = "";

	// If the page was opened as a post method then perform code
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
		// Check that all input parameters are entered
		if(empty(trim($_POST["requestTitle"]))) {
			$requestType_err = "Please enter a title.";
		} else {
			$requestTitle = trim($_POST["requestTitle"]);
		}

		if(empty(trim($_POST["furtherDetails"]))) {
			$furtherDetails_err = "Please enter a description.";
		} else {
			$furtherDetails = trim($_POST["furtherDetails"]);
		}
		
		if((trim($_POST["requestType"])) == "#") {
			$requestType_err = "Please select a type.";
		} else {
			$requestType = trim($_POST["requestType"]);
		}
		
		/*
		if((trim($_POST["distance"])) == "#") {
			$distance_err = "Please select a distance.";
		} else {
			$distance = trim($_POST["distance"]);
		}
		*/
		
		if((trim($_POST["duration"])) == "#") {
			$duration_err = "Please select a duration.";
		} else {
			$duration = trim($_POST["duration"]);
		}
		
		if((trim($_POST["startDate"])) == "#") {
			$startDate_err = "Please select a date.";
		} else {
			$startDate = trim($_POST["startDate"]);
		}

		// If there are no errors with the POST methods then insert the job reuqest
		//  into the database
		if(empty($requestTitle_err) && empty($requestType_err) && empty($furtherDetails_err) && empty($duration_err) && empty($startDate_err)) {
			$addJob = "INSERT INTO jobs (userID, userType, jobTitle, jobType, jobDescription, duration, startDate) VALUES (?, ?, ?, ?,  ?, ?, ?)";
			if($add = mysqli_prepare($link, $addJob)) {
				mysqli_stmt_bind_param($add, "sssssss", $param_userID, $param_userType, $param_jobTitle, $param_jobType, $param_jobDescription, $param_duration, $param_startDate);
				$param_userID = $userID;
				$param_userType = $userType;
				$param_jobTitle = $requestTitle;
				$param_jobType = $requestType;
				$param_jobDescription = $furtherDetails;
				$param_duration = $duration;
				$param_startDate = $startDate;
				
				if(mysqli_stmt_execute($add)) {
					header("location: CreateRequest.php");
				}
				else {
					echo $add->error;
				}
			}
		}
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
		<title>Create <?php echo $jobTypeCapital; ?></title>
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
				<div class="col-sm-8">
					<!-- The below form is to be filled in in full to insert into the database -->
					<h2>Create <?php echo $jobTypeCapital; ?></h2>
					<h4>Please fill out the following form to create <?php echo $jobTypeWithPrefix; ?>.</h4>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div>
							<label for="requestTitle"><?php echo $jobTypeCapital; ?> Title</label>
							<br>
							<input type="text" id="requestTitle" name="requestTitle" placeholder=" ">
							<?php if (empty($userID_err)) { 
									} else { ?>
							<p><?php echo $userID_err; ?></p>
							<?php } ?>
						</div>
					
						<div>
							<label for="requestType"><?php echo $jobTypeCapital; ?> Type</label>
							<br>
							<select type="text" id="requestType" name="requestType">
									<option value="#">Please choose <?php echo $jobTypeWithPrefix; ?> type...</option>
									<option value="1">Shopping</option>
									<option value="2">Retrieving Medication</option>
									<option value="3">Caring for / walking pet</option>
									<option value="4">House tasks</option>
									<option value="5">Other</option>
							</select>
						</div>
						
						<div>
							<label for="furtherDetails">Further Details</label>
							<br>
							<input class="large-text" type="text" id="furtherDetails" name="furtherDetails" placeholder=" ">
							<?php if (empty($userID_err)) { 
									} else { ?>
							<p><?php echo $userID_err; ?></p>
							<?php } ?>
						</div>
						
						<!--
						<div>
							<label for="distance">Distance</label>
							<br>
							<select type="text" id="distance" name="distance">
									<option value="#">Please choose a distance from your home...</option>
									<option value="1">In my Area</option>
									<option value="2">In my District</option>
									<option value="3">In my Sub-District</option>
									<option value="4">Anywhere</option>
							</select>
						</div>
						-->
						
						<div>
							<label for="duration">Duration</label>
							<br>
							<select type="text" id="duration" name="duration">
									<option value="#">Please choose a duration of your <?php echo $jobTypeLower; ?>...</option>
									<option value="1">1 day</option>
									<option value="2">1 week</option>
									<option value="3">2 weeks</option>
									<option value="3">2+ weeks</option>
							</select>
						</div>
						
						<div>
							<label for="startDate">Start Date</label>
							<br>
							<input type="date" name="startDate" min="<?php echo date('Y-m-d'); ?>" max="2020-12-31" value="<?php echo date('Y-m-d'); ?>">
							<?php if (empty($startDate_err)) { 
									} else { ?>
							<p><?php echo $startDate_err; ?></p>
							<?php } ?>
						</div>
						
						<br>
						<input type="submit" value="Create <?php echo $jobTypeCapital; ?>">
					</form>
				</div>
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>