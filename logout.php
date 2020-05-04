<?php
// Session start and connection file inclusion
session_start();

// Reset the session variables to log the user out
unset($_SESSION["login_user"]);
unset($_SESSION['userType']);

header("Location: index.php");

?>