<?php
@include "../conection_database.php";
@include "calc_stringedit.php";

$idcourse = $_POST["idcourse"];


$sql = "SELECT Student.id as studentid FROM Student INNER JOIN Enrollment ON enrollment.Student_id = Student.id WHERE enrollment.Course_id = 2";

$result2 = $mysqli->query($sql);

$array = [];
//get all projects
while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $array[] = $row2;
}

echo json_encode($array);