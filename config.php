<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "cashbook";

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$con)
    die("Fail to connect");

?>