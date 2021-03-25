<?php
$host = "localhost";
$user="root";
$password="";

$databasename = "PEEF_BD";
$mysqli = new mysqli($host,$user,$password,$databasename);

$mysqli->set_charset("utf8");

if($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

return;
$host = "localhost";
$user="inages98_root";
$password="T1rul1p@";
$databasename = "inages98_peef";

$mysqli = mysqli_connect($host, $user, $password, "inages98_peef");


if (!$mysqli) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>
