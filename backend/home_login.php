<?php
@include "conection_database.php";

if(isset($_POST["login"]))
    $login = $_POST["login"];
if(isset( $_POST["password"]))
    $pass = $_POST["password"];
if(isset($_POST["mode"]))
    $mode = $_POST["mode"];


/*$login = "teste@gmail.com";
$pass = "12345";
$mode = "1";*/

$query ="SELECT id FROM ";

if($mode == "1")
    $query .= " Student ";
else
    $query .= " Professor ";

$query .= " WHERE email= '$login' AND password= md5('$pass') ";

$result = $mysqli->query($query);

$id = $result->fetch_array()["id"];

if(  !$id ){
    echo "error" ;
}else{
    echo $id ;
}

?>