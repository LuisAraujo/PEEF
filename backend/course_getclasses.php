<?php

@include "conection_database.php";
@include "manager_section.php";

$query = "SELECT * FROM Classes WHERE Course_id = ".getcurrentcourse_session();
$result = $mysqli->query($query);

$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>