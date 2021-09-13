<?php
@require_once "../conection_database.php";
@include "calc_errormetrics.php";

$idstudent = $_POST["idstudent"];

$array2 = array();

$query2 = "SELECT Project.id as id, Project.Activity_id as idactivity FROM project INNER JOIN enrollment ON enrollment_id = enrollment.id INNER JOIN student ON Student_id = student.id WHERE Enrollment.Student_id = '" . $idstudent . "'";
$result2 = $GLOBALS['mysqli']->query($query2);
while ($row2 = $result2->fetch_assoc()) {
    $array3 = array();
    $array3["id"] = $row2["id"];
    $array3["idactivity"] = $row2["idactivity"];
    $array3["score"] = number_format(getRED($idstudent, $row2["id"]), 2, '.', ';');
    $array2[] = $array3;
}

echo json_encode($array2);
