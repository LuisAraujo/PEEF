<?php
@include "../conection_database.php";
@include "calc_stringedit.php";

$idcourse = $_POST["idcourse"];


$sql = "SELECT Project.id as projectid, Student.id as studentid FROM Project INNER JOIN Enrollment ON enrollment.id = Enrollment_id INNER JOIN student On enrollment.Student_id = student.id WHERE enrollment.Course_id = 2 ORDER BY Enrollment_id";

$result2 = $mysqli->query($sql);

$array = [];
//get all projects
while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $array[] = $row2;
}

echo json_encode($array);