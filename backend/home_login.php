<?php
@include "conection_database.php";
@include "manager_section.php";

$login = $_POST["login"];
$pass = $_POST["password"];
$mode = $_POST["mode"];

$query ="SELECT count(*) as count FROM ";

if($mode == "1")
    $query .= " Student ";
else
    $query .= " Professor ";

$query .= " WHERE email= '$login' AND password= md5('$pass') ";

$result = $mysqli->query($query);

if(  ! $result->fetch_array()["count"] ){
    echo $query ;
}else{
    echo "logged";
}

?>