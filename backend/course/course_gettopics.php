<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourse = 1; //$_POST["idcourse"]
$array = array();

$sql = "SELECT id, title FROM Topic WHERE Course_id = ".$idcourse;

$result = $mysqli->query($sql);

while( $row = $result->fetch_assoc()){

    $array[] = $row;

}

echo json_encode($array);