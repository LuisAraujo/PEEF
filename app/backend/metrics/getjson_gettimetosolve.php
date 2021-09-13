<?php

/*Get time to solve problems.*/

@include "calc_time.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

$array = array();
$array["totaltime"] = calcTimeInPlatform($idcourse, $idstudent);
$array["solved"] = array();

$sql = "SELECT  Project.id FROM Activity INNER JOIN Project ON Activity.id  = Project.Activity_id INNER JOIN Topic ON Topic.id  = Activity.Topic_id INNER JOIN Course ON Topic.Course_id = Course.id INNER JOIN Enrollment ON Enrollment.Course_id = Course.id WHERE Enrollment.Student_id = ".$idstudent;

$result = $mysqli->query($sql);

while($row = $result->fetch_assoc()){
    $array2 = array();
    $idactivity = $row["id"];
    $array2["activity"] = $idactivity;
    $array2["time"] = calcTimeToSolve($idcourse, $idstudent, $idactivity);
    $array["solved"][] = $array2;
}

echo json_encode($array);