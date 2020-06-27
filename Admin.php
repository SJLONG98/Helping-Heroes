<?php
	// Session start and connection file inclusion
	session_start();

	if ($_SESSION['userType'] != 1) {
		header("location: index.php");
	}
	include("connection.php");
	
	// Sets up query for all users which have a pending vetted status
	$getUsers = "SELECT * FROM users WHERE isVetted is null AND vettingFileName is not null";
	$result = mysqli_query($link, $getUsers);

	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$insertOneDay = "INSERT INTO jobs_history SELECT * FROM jobs WHERE DATE_ADD(startDate, INTERVAL 1 DAY) < CURDATE();";
		$deleteOneDay = "DELETE FROM jobs WHERE DATE_ADD(startDate, INTERVAL 1 DAY) < CURDATE();";
		if($ins1d = mysqli_prepare($link, $insertOneDay)) {
			mysqli_stmt_execute($ins1d);
		}
		if($del1d = mysqli_prepare($link, $deleteOneDay)) {
			mysqli_stmt_execute($del1d);
		}
		
		$insertOneWeek = "INSERT INTO jobs_history SELECT * FROM jobs WHERE DATE_ADD(startDate, INTERVAL 7 DAY) < CURDATE();";
		$deleteOneWeek = "DELETE FROM jobs WHERE DATE_ADD(startDate, INTERVAL 7 DAY) < CURDATE();";
		if($ins1w = mysqli_prepare($link, $insertOneWeek)) {
			mysqli_stmt_execute($ins1w);
		}
		if($del1w = mysqli_prepare($link, $deleteOneWeek)) {
			mysqli_stmt_execute($del1w);
		}
		
		$insertTwoWeeks = "INSERT INTO jobs_history SELECT * FROM jobs WHERE DATE_ADD(startDate, INTERVAL 14 DAY) < CURDATE();";;
		$deleteTwoWeeks = "DELETE FROM jobs WHERE DATE_ADD(startDate, INTERVAL 14 DAY) < CURDATE();";
		if($ins2w = mysqli_prepare($link, $insertTwoWeeks)) {
			mysqli_stmt_execute($ins2w);
		}
		if($del2w = mysqli_prepare($link, $deleteTwoWeeks)) {
			mysqli_stmt_execute($del2w);
		}
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
		<link rel="icon" href="#"/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<title>Admin</title>
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
					<h2>Approve or Deny Users</h2>
					<?php while($row = mysqli_fetch_array($result)){ ?>
						<div class="job">
							<div class="job_inf">
								<h3><?php echo $row[0]; ?></h3>
								<a href="/helpingheroes/<?php echo $row[11]; ?>" download>Click here to download vetting file</a>
							</div>
							<div class="job_btn">
								<form action ="approveDenyUser.php" method = "post">
									<button type='submit' name='approve' value=<?php echo "'{$row[0]}'" ?>>Approve</button>
									<button type='submit' name='deny' value=<?php echo "'{$row[0]}'" ?>>Deny</button>
								</form>
							</div>
						</div>
					<?php }; ?>
				</div>
				<!--
				<div class="col-sm-2 sidenav"></div>
				<div class="col-sm-3">
					<a href="AdminLists.php" class="button">Aproval List</a>
				</div>
				-->
				<div class="col-sm-2 sidenav"></div>
			</div>
			<div class="row content">
				<form action ="Admin.php" method = "post">
					<button type='submit'>UPDATE JOBS</button>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>