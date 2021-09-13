<?php

@include "calc_time.php";
$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

echo calcTimeByWeekday( $idcourse, $idstudent);
