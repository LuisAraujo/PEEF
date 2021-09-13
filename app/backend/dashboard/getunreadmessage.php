<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourse = 2;

$query = "SELECT Project.id as id, Student.name as namestud, Student.id as idstud, Activity.title as title FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id INNER JOIN Student ON Enrollment.Student_id = Student.id WHERE Activity.Topic_id IN (Select id From Topic WHERE Course_id = $idcourse)";

$result = $mysqli->query($query);
$myArray = array();
$row2 = [];

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

    $query7 = "SELECT Count(*) as unviewed FROM Message WHERE Project_id = '" . $row["id"] . "' AND hasview = 0 AND fromprofessor = 0";
    $result7 = $mysqli->query($query7);
    $unviwed= $result7->fetch_assoc()["unviewed"];
    if(  intval($unviwed) > 0){
        $row["unviewed"] = $unviwed;
        $row2[] = $row;
    }

}

echo json_encode($row2);