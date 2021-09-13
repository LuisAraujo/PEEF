<?php
@include "calc_datacompilation.php";

$idstudent = $_POST["idstudent"];
$idcourse = $_POST["idcourse"];

$array = array();
$sql = "SELECT Activity.id as act_id, Project.id as project_id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id WHERE  Enrollment.Student_id = ".$idstudent." AND Enrollment.Course_id = ".$idcourse. " ORDER BY Activity.id";

$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {

    $idproject = $row["project_id"];

    $array2 = array();
    $array2["project_id"] = $idproject;

    $array2["test"] = getCountTests($idproject);

    if($array2["test"] != 0)
        $array2["passed"] = getCountPassedTest($idproject);
    else
        $array2["passed"] = 0;

    $array2["npassed"] = intval($array2["test"]) - intval($array2["passed"]);


    $array[] = $array2;

}


echo json_encode($array);
