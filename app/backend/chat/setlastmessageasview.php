<?php

@include "../conection_database.php";
@include "../session/manager_section.php";


if(isset( $_POST["lastidmsg"]))
    $lastidmsg = $_POST["lastidmsg"];

if(isset( $_POST["idproject"])) {
    if($_POST["idproject"] != "-1")
        $idproject = $_POST["idproject"];
    else
        $idproject = getcurrentproject_session();
}


if(isset( $_POST["fromprof"]))
    $fromprofessor = $_POST["fromprof"];


$query = "UPDATE Message SET hasview = 1 WHERE Project_id = '$idproject' AND id <= '$lastidmsg' AND hasview = '0' AND fromprofessor = '$fromprofessor'";
$result = $mysqli->query($query);

if($result)
    echo json_encode("{'status':'ok'}");
else
    echo json_encode("{'status':'error'}");


?>