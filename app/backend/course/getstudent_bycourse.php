<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$courseid = getcurrentcourse_session();

$query = "SELECT Student.id, Student.name FROM enrollment INNER JOIN Student ON Student.id = Student_id WHERE Course_id = ".$courseid;
$result = $mysqli->query($query);

$arrajson = '[';

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arrajson .= '{"id": "'.$row['id'].'", "name": "'.$row['name'].'"  } ';
    $arrajson .= ",";
}

$arrajson = substr( $arrajson, 0, -1);
$arrajson .= "]";

echo $arrajson;

?>