<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");

	if (isSet($_POST['jobID'])) {
		$jobID = $_POST['jobID'];
	}
	
	if (empty($jobID)) {
		$jobID = $_SESSION['currJobID'];
	} else {
		$_SESSION['currJobID'] = $jobID;
	}

	// Setting page variables to be used in the code
	if(isset($_SESSION['userType'])) {
		if($_SESSION['userType'] == 2) {
			$otherType = "3";
			$jobTypeCapital = "Request";
		} elseif($_SESSION['userType'] == 3) {
			$otherType = "2";
			$jobTypeCapital = "Offer";
		} else {
			$otherType = "2,3";
			$jobTypeCapital = "";
		}
	} else {
		$otherType = "2,3";
		$jobTypeCapital = "";
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

	$getJobs = "SELECT jobTitle, jobType, jobDescription FROM jobs WHERE jobID = \"{$jobID}\";";
	$result = mysqli_query($link, $getJobs);
	$row = mysqli_fetch_array($result)
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
		<link rel="icon" href="#"/>
		<title>Helping Heroes</title>
	</head>
	<body>
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div class="container-fluid text-center">
			<div class="row content">
				<h2 id="titleText"><?php echo $row[0]; ?></h2>
			</div>
			<div class="row content">
				<div class="col-sm-2 sidenav"></div>
				<!-- This div contains the details for a list of all jobs
						with limits on whether the user is signed in and
						their user type -->
				<div class="col-sm-8 text-center">
					<ul id="resultList">
						<li>
							<p id="jobTypeText"><?php echo getJobType($row[1]); ?></p>
							<p id="jobDescText"><?php echo $row[2]; ?></p>
						</li>
					</ul>
					<?php if(isset($_SESSION['login_user'])) { ?>
						<?php if($_SESSION['userType'] != 1 && $_SESSION['isVetted'] == 1) { ?>
							<form action ="claimJob.php" method = "post">
								<button type='submit' name='claim' value=<?php echo $jobID; ?> >Claim <?php echo $jobTypeCapital; ?></button>
							</form>
						<?php } ?>
					<?php } else { ?>
						<a href="CreateAccount.php">Login/Register to claim</a>
					<?php }; ?>
				</div>
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>