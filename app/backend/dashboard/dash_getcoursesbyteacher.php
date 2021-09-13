<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

if(getcurrentuser_session() == "-1") {
    echo "[]";
}else {

    $query = "SELECT course.id as id, course.name as name, course.code as code FROM course WHERE Professor_id = " . getcurrentuser_session();

    $result = $mysqli->query($query);
    $myArray = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        array_push($myArray, $row);
    }

    echo json_encode($myArray);
}

?>