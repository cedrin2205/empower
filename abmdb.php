<?php

$sname = "localhost";
$uname = "root";
$password = "";

$db_name = "abmteacher";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
	exit();
}