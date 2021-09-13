<?php
@require_once "../conection_database.php";

function getCountMessages($idproject){
    $query = "SELECT count(*) as msg FROM Message  WHERE Project_id = " . $idproject. " AND fromprofessor = 0 ";
    $result = $GLOBALS['mysqli']->query($query);
    return $result->fetch_assoc()["msg"];
}

