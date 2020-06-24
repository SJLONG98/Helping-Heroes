<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");

	if (isset($_SESSION['overlayCheck'])) {
		$overlayCheck = $_SESSION['overlayCheck'];
	} else {
		$overlayCheck = "None";
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

	// Sets up query for all jobs which has the inverse type of the current user
	$getJobs = "SELECT a.jobTitle, a.jobType, a.jobDescription, b.postcode, a.jobID FROM jobs a LEFT JOIN user b ON a.userID = b.userId WHERE a.pairedUserId is null AND a.isApproved is null AND a.userType in ({$otherType})";
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" href="images/Hlogo.png" type="image/png" sizes="16x16">
		<title>Helping Heroes</title>
	</head>
	<body >
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div class="container-fluid text-center">
			<div class="row content">
				<h2>Welcome to Helping Heroes</h2>
				<p>*To be able to claim a job you must be logged in and approved by an admin</p>
				<input type="text" id="filterInput" onkeyup="getResults()" placeholder="Enter a postcode..." title="Filter by Postcode">
				<div>
					<select type="text" id="requestType" name="requestType" onchange="filterFunction()">
						<option value="#">Select a job type</option>
						<option value="Shopping">Shopping</option>
						<option value="Retrieving Medication">Retrieving Medication</option>
						<option value="Caring for / walking pet">Caring for / walking pet</option>
						<option value="House tasks">House tasks</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div>
			<div class="row content" >
				<div class="col-sm-2 sidenav"></div>
				<!-- This div contains the details for a list of all jobs
						with limits on whether the user is signed in and
						their user type -->
				<div class="col-sm-8 text-center" id= >
					<ul id="resultList" >
						<?php $i=0; while(($row = mysqli_fetch_array($result)) && ($i<10)){ ?>
						<li class="col-xs-6 col-sm-6 col-md-4 col-lg-4 jobItem" id=joblist>
						<div class="card">
							<form action="JobDetails.php" method="post">
								<button type="submit" name="jobID" value="<?php echo $row[4]; ?>" class="headerButton"><?php echo $row[0]; ?></button>
								<p id="jobTypeText"><?php echo getJobType($row[1]); ?></p>
								<p id="jobDescText"><span id="jobDesc"><?php echo $row[2]; ?></span></p>
								<p id="postcodeText"><?php echo $row[3]; ?></p>
							</form>
							<?php if(isset($_SESSION['login_user'])) { ?>
								<?php if($_SESSION['userType'] != 1 && $_SESSION['isVetted'] == 1) { ?>
									<form action ="claimJob.php" method = "post">
										<button type='submit' name='claim' value=<?php echo "'{$row[4]}'" ?> >Claim <?php echo $jobTypeCapital; ?></button>
									</form>
								<?php } ?>
							<?php } else { ?>
								<a href="CreateAccount.php">Login/Register to claim</a>
							<?php $i++; }; ?>
							</div>
						</li>
						<?php }; ?>
					</ul>
				</div>
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		
		<script type="text/javascript">
			function getResults() {
				var input, filter, ul, li, postcodeText, i, txtValue;
				input = document.getElementById("filterInput");
				filter = input.value.toUpperCase();
				ul = document.getElementById("resultList");
				li = ul.getElementsByTagName("li");
				for (i = 0; i < li.length; i++) {
					postcodeText = li[i].getElementsByTagName("p")[2];
					txtValue = postcodeText.textContent || postcodeText.innerText;
					if (txtValue.toUpperCase().indexOf(filter) > -1) {
						li[i].style.display = "";
					} else {
						li[i].style.display = "none";
					}
				}
			}
			
			function filterFunction() {
				var input, ul, li, jobTypeText, i, txtValue;
				input = document.getElementById("requestType").value;
				console.log(input);
				ul = document.getElementById("resultList");
				li = ul.getElementsByTagName("li");
				for (i = 0; i < li.length; i++) {
					jobTypeText = li[i].getElementsByTagName("p")[0];
					txtValue = jobTypeText.textContent || jobTypeText.innerText;
					if (txtValue.indexOf(input) > -1 || input == "#") {
						li[i].style.display = "";
					} else {
						li[i].style.display = "none";
					}
				}
			}
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<div> <?php include("footer.php"); ?> </div>
	</body>
</html>