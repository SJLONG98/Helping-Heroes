<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
	include("connection.php");
	
	// Sets up query for all jobs which are in pending status
	$getJobs = "SELECT * FROM jobs WHERE pairedUserId is not null and isApproved is null";
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
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" href="#"/>
		<title>All Jobs</title>
	</head>
	<body>
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div id="site_content">
			<div id="content">
				<h2>Welcome to Helping Heroes</h2>
				<?php while($row = mysqli_fetch_array($result)){ ?>
					<div class="job">
						<div class="job_inf">
							<h3><?php echo $row[2]; ?></h3>
						</div>
						<div class="job_btn">
							<form action ="approveDenyJob.php" method = "post">
								<button type='submit' name='approve' value=<?php echo "'{$row[10]}'" ?>>Approve</button>
								<button type='submit' name='deny' value=<?php echo "'{$row[10]}'" ?>>Deny</button>
							</form>
						</div>
					</div>
				<?php }; ?>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>