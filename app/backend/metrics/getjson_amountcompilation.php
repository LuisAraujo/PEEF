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

    $array2["compilations"] = getCountCompilations($idproject);

    if($array2["compilations"] != 0)
        $array2["error"] = getCountCompilationError($idproject);
    else
        $array2["error"] = 0;

    $array2["success"] = intval($array2["compilations"]) - intval($array2["error"]);


    $array[] = $array2;

}


echo json_encode($array);
