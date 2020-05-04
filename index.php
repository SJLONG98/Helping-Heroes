<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");

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

	// Sets up query for all jobs which has the inverse type of the current user
	$getJobs = "SELECT * FROM jobs WHERE pairedUserId is null AND isApproved is null AND userType in ({$otherType})";
	$result = mysqli_query($link, $getJobs);
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
		<title>Helping Heroes</title>
	</head>
	<body>
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div id="site_content">
			<div id="content">
				<!-- This div contains the details for a list of all jobs
						with limits on whether the user is signed in and
						their user type -->
				<h2>Welcome to Helping Heroes</h2>
				<?php while($row = mysqli_fetch_array($result)){ ?>
					<div class="job">
						<div class="job_inf">
							<h3><?php echo $row[2]; ?></h3>
							<p><?php echo getJobType($row[3]); ?></p>
							<p><?php echo $row[4]; ?></p>
						</div>
						<div class="job_btn">
							<!-- This div shows a button for logged in users to claim a job
									and links to login for other users-->
							<?php if(isset($_SESSION['login_user'])) { ?>
								<?php if($_SESSION['userType'] != 1) { ?>
								<form action ="claimJob.php" method = "post">
									<button type='submit' name='claim' value=<?php echo "'{$row[10]}'" ?> >Claim <?php echo $jobTypeCapital; ?></button>
								</form>
								<?php } ?>
							<?php } else { ?>
								<a href="CreateAccount.php">Login/Register to claim</a>
							<?php }; ?>
						</div>
					</div>
				<?php }; ?>
			</div>
		</div>
		<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
	</body>
</html>