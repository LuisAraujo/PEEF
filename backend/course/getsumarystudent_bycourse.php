<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$courseid = getcurrentcourse_session();

$query = "SELECT enrollment.id as enrollment, Student.id, Student.name FROM enrollment INNER JOIN Student ON Student.id = Student_id WHERE Course_id = ".$courseid;
$result = $mysqli->query($query);

$arrajson = '[';


while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $query2 = "SELECT Count(*) as compilation FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE Enrollment.id = ".$row["enrollment"];
    $query3 = "SELECT Count(*) as errorcomp FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE compilation.typeError != 'no-error' AND Enrollment.id = ".$row["enrollment"];
    $query4 = "SELECT Count(*) as passed FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE compilation.testpassed != '-1' AND Enrollment.id = ".$row["enrollment"];

    $result2 = $mysqli->query($query2);
    $result3 = $mysqli->query($query3);
    $result4 = $mysqli->query($query4);

    $row2 = $result2->fetch_array(MYSQLI_ASSOC);
    $row3 = $result3->fetch_array(MYSQLI_ASSOC);
    $row4 = $result4->fetch_array(MYSQLI_ASSOC);

    $arrajson .= '{"id": "'.$row['id'].'", "name": "'.$row['name'].'" , "compilation": "'.$row2['compilation'].'",  "error": "'.$row3['errorcomp'].'" , "passed": "'.$row4['passed'].'"} ';
    $arrajson .= ",";
}

$arrajson = substr( $arrajson, 0, -1);
$arrajson .= "]";

echo $arrajson;

?>