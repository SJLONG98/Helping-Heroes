<?php
	// Session check and connection file inclusion
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	include("connection.php");
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="icon" href="images/Hlogo.png" type="image/png" sizes="16x16">
		<title>Password Reset</title>
	</head>
	<?php
	include("Navbar.php");
	?>
		<main>
			<div class="container-fluid text-center">
				
                <?php
                $selector = $_GET["selector"];
                $validator = $_GET["validator"];

                if (empty($selector) || empty($validator)) {
                    echo "we could not validate your request" ;
                } else {
                    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {       
                ?>

                <form action="resetPassword.php" method="post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <input type="password" name="pwd" placeholder="Enter a new ppassword">
                <input type="passwordRepeat" name="pwdRepeat" placeholder="Repeat new password">
                <button type="submit" name="ResetPasswordSubmit"> Reset password </button>
                
                <?php
            
                    }
                }
                ?>
				
			</div>
		</main>
	<body>

		
		
				<div class="col-sm-2 sidenav"></div>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	</body>
</html>