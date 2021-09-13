<?php
@include "calc_time.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

$array = array();
$sql = "SELECT Activity.id as act_id, Project.id as project_id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id WHERE  Enrollment.Student_id = ".$idstudent." AND Enrollment.Course_id = ".$idcourse. " ORDER BY Activity.id";

$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    $idproject = $row["project_id"];
    $array2 = array();
    $array2["project_id"] = $row["project_id"];
    $array2["id"] = $row["act_id"];
    $array2["data"] = calcTimeToSolve( $idcourse, $idstudent, $idproject);
    $array[] = $array2;
}

echo json_encode($array);
