<?php

$host = "localhost";
$user="root";
$password="";

$databasename = "PEEF_BD";
$mysqli = new mysqli($host,$user,$password,$databasename);

if($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>