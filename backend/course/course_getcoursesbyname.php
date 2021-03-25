<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$namecourse  = $_POST["namecourse"];

$query = "SELECT course.id as id, course.name as name, course.code as code, professor.name as profname FROM course INNER JOIN professor ON professor.id = course.Professor_id INNER JOIN enrollment ON enrollment.Course_id = course.id AND enrollment.Student_id = ".getcurrentuser_session();
$query .= " WHERE Course.name LIKE '%$namecourse%' ";


$result = $mysqli->query($query);
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>