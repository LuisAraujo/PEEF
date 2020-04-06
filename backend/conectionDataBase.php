<?php

$host = "localhost";
$user="root";
$password="";

$databasename = "PEEF_BD";
$mysql = new mysqli($host,$user,$password,$databasename);

if($mysql->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>