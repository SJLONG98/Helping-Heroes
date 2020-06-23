<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'helpingh_admin');
define('DB_PASSWORD', 'TEAMEISDABEST');
define('DB_NAME', 'helpingheroes_db');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
