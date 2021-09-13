<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$query = "SELECT * FROM classes WHERE Course_id = ".getcurrentcourse_session(). " AND (show_after <= CURDATE() OR show_after is NULL) ";
$result = $mysqli->query($query);

$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>