<?php
	// Session start and connection file inclusion
	session_start();

	if ($_SESSION['userType'] != 1) {
		header("location: index.php");
	}
	include("connection.php");
	
	// Sets up query for all users which have a pending vetted status
	$getUsers = "SELECT * FROM user WHERE isVetted is null AND vettingFileName is not null";
	$result = mysqli_query($link, $getUsers);

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
		<title>Admin</title>
	</head>
	<body>
		<?php 
			// Necessary reference to include our dynamic navbar
			include("Navbar.php");
		?>
		<div id="site_content">
			<div id="content">
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
			<div id="sidebar_content">
				<a href="AdminLists.php" class="button">Aproval List</a>
			</div>
		</div>
		<script type="text/javascript" src="//code.jquery.com/jquery.min.js"></script>
	</body>
</html>