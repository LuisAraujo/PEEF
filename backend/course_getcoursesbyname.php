<?php

@include "conection_database.php";
@include "manager_section.php";

$namecourse  = $_POST["namecourse"];

$query = "SELECT Course.id as id, Course.name as name, Course.code as code, Professor.name as profname FROM Course INNER JOIN Professor ON Professor.id = Course.Professor_id INNER JOIN Enrollment ON Enrollment.Course_id = Course.id AND Enrollment.Student_id = ".getcurrentuser_session();
$query .= " WHERE Course.name LIKE '%$namecourse%' ";


$result = $mysqli->query($query);
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>