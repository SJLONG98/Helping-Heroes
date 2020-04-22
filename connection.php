<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'helpingheroes');
define('DB_PASSWORD', 'this is a password');
define('DB_NAME', 'helpingheroes_db');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>