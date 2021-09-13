<?php
@include "calc_datamessage.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

$array = array();
$sql = "SELECT Activity.id as act_id, Project.id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id WHERE  Enrollment.Student_id = ".$idstudent." AND Enrollment.Course_id = ".$idcourse;

$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    $idproject = $row["id"];
    $array2 = array();
    $array2["id"] = $row["act_id"];
    $array2["data"] = getCountMessages($idproject);
    $array[] = $array2;
}

echo json_encode($array);
