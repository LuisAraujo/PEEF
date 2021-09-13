<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourse = $_POST["idcourse"];

if(getcurrentuser_session() == "-1") {
    echo "[]";
}else {

    $query = "SELECT topic.id as id, topic.title as name FROM topic WHERE Course_id = ".$idcourse;

    $result = $mysqli->query($query);
    $myArray = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        array_push($myArray, $row);
    }

    echo json_encode($myArray);
}
