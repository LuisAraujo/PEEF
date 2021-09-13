<?php

@include "../conection_database.php";
@include "../session/manager_section.php";


if(isset( $_POST["idproject"])) {
    if($_POST["idproject"] != "-1")
        $idproject = $_POST["idproject"];
    else
        $idproject = getcurrentproject_session();
}


if(isset( $_POST["fromprof"]))
    $fromprofessor = $_POST["fromprof"];


$query = "SELECT Count(*) as countmessage FROM Message WHERE Project_id = '$idproject'  AND hasview = '0' AND fromprofessor = '$fromprofessor'";
$result = $mysqli->query($query);

echo $row = $result->fetch_assoc()["countmessage"];



?>