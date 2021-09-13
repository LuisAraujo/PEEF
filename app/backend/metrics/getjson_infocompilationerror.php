<?php

@include "../conection_database.php";
$idcourse = 2;//$_POST["idcourse"];


$sql = "SELECT Enrollment.Student_id, Compilation.id, typeError, enhancedmessage.enhancedmessage, compMessage FROM `compilation` INNER JOIN Code ON Code.id = Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Enrollment.id =  Project.Enrollment_id  LEFT JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound  WHERE Enrollment.Course_id = '$idcourse' AND  typeError <> 'no-error'";
$result = $mysqli->query($sql);
$arr = [];

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arr[] = $row;
}

echo json_encode($arr);