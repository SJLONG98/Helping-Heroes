<?php

session_start();

unset($_SESSION["login_user"]);
unset($_SESSION['userType']);

header("Location: index.php");

?>