<?php
	// Session check and connection file inclusion
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	include("connection.php");


	// Safety measure to prevent incorrect page access
	if ($_SESSION['userType'] == 1) {
		header("location: Admin.php");
	}
	
	// Setting page variables to be used in the code
	$userID = $_SESSION['userID'];
	
	if($_SESSION['userType'] == 2) {
		$jobTypeLower = 'offer';
		$jobTypeCapital = 'Offer';
		$jobTypeWithPrefix = 'an offer';
		$userTypeDesc = 'Volunteer';
	} elseif($_SESSION['userType'] == 3) {
		$jobTypeLower = 'request';
		$jobTypeCapital = 'Request';
		$jobTypeWithPrefix = 'a request';
		$userTypeDesc = 'Key Worker';
	}
	
	// Create a function to get correct Job Type from the database key value
	function getJobType($jobCode) {
		switch ($jobCode) {
			case 1:
				return "Shopping";
			case 2:
				return "Retrieving Medication";
			case 3:
				return "Caring for / walking pet";
			case 4:
				return "House tasks";
			case 5:
				return "Other";
			default:
				return "N/A";
		}
	}
	
	// Sets up query for all jobs the user has created
	$getJobs = "SELECT * FROM jobs WHERE userID = \"{$userID}\" UNION SELECT * FROM jobs_history WHERE userID = \"{$userID}\";";
	$result = mysqli_query($link, $getJobs);
	
	// Sets up query for all jobs the user has claimed
	$getPendingJobs = "SELECT * FROM jobs WHERE pairedUserID = \"{$userID}\" AND isApproved is null";
	$resultPending = mysqli_query($link, $getPendingJobs);
	
	// Sets up query for all jobs the user has claimed
	$getDeniedJobs = "SELECT * FROM jobs WHERE pairedUserID = \"{$userID}\" AND isApproved = 0";
	$resultDenied = mysqli_query($link, $getDeniedJobs);
	
	// Sets up query for all jobs the user has claimed
	$getActiveJobs = "SELECT * FROM jobs WHERE pairedUserID = \"{$userID}\" AND isApproved = 1";
	$resultActive = mysqli_query($link, $getActiveJobs);
	
	// Sets up query for all the user details
	$getUserDetails = "SELECT * FROM user WHERE userID = \"{$userID}\"";
	$resultUser = mysqli_query($link, $getUserDetails);
	
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
		<link rel="icon" href="#"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<title>Profile</title>
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
					<!-- This div contains a list of all a user's created jobs -->
					<h2>Hi <?php echo $_SESSION['userID'];?>!</h2>
					<h3>This is where you can review your <?php echo $jobTypeLower; ?>s.</h3>
					<?php while($row = mysqli_fetch_array($result)){ ?>
						<div class="job">
							<div class="job_inf">
								<div><?php echo $row[2]; ?></div>
								<div><?php echo getJobType($row[3]); ?></div>
								<div><?php echo $row[4]; ?></div>
							</div>
						</div>
						<br>
					<?php }; ?>
				</div>
				<div class="col-sm-2 sidenav"></div>
				<div class="col-sm-3">
					<!-- This div contains the details for the current user
							as well as the link to the edit account page to
							add to these details.
						 It also contains a list of current pending jobs -->
				    <h3>Details</h3>
					<a href="EditAccount.php" class="button">Edit Account</a>
					<?php while($row = mysqli_fetch_array($resultUser)){ ?>
						<div><?php echo $userTypeDesc; ?></div>
						<div><?php echo $row[1]; ?></div>
						<div><?php echo $row[6]; ?></div>
						<div><?php echo $row[7]; ?></div>
						<div><?php echo $row[8]; ?></div>
					<?php }; ?>
					<h3>Active <?php echo $jobTypeCapital; ?>s</h3>
					<?php while($row = mysqli_fetch_array($resultActive)){ ?>
						<div><?php echo $row[2]; ?></div>
						<div><?php echo getJobType($row[3]); ?></div>
						<div><?php echo $row[4]; ?></div>
						<form action ="completeCancelJob.php" method = "post">
							<button type='submit' name='complete' value=<?php echo "'{$row[10]}'" ?>>Complete</button>
							<button type='submit' name='cancel' value=<?php echo "'{$row[10]}'" ?>>Cancel</button>
						</form>
					<?php }; ?>
					<h3>Pending <?php echo $jobTypeCapital; ?>s</h3>
					<?php while($row = mysqli_fetch_array($resultPending)){ ?>
						<div><?php echo $row[2]; ?></div>
						<div><?php echo getJobType($row[3]); ?></div>
						<div><?php echo $row[4]; ?></div>
					<?php }; ?>
				</div>
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>