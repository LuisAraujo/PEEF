<?php

/*Get time in platform*/

@include "calc_time.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

$array = array();
$array["totaltime"] = calcTimeInPlatform($idcourse, $idstudent);

echo json_encode($array);