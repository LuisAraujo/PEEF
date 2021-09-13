<?php

/*Get time of student by days*/

@include "calc_time.php";
$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

echo calcTimeByDay( $idcourse, $idstudent);
