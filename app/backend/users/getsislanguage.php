<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$array = [];

$sql = "SELECT * FROM Sis_Language WHERE 1";
$result =  $mysqli->query($sql);

while( $row = $result->fetch_assoc() ){
    $array[]= $row;
}

echo json_encode($array);