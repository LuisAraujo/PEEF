<?php

@include "../conection_database.php";
@include "../session/manager_section.php";


if(isset( $_POST["fromprof"]))
    $fromprof = $_POST["fromprof"];

if(isset( $_POST["text"]))
    $text = $_POST["text"];

if(isset( $_POST["idproject"]))
    $idproject = $_POST["idproject"];

$sql = "INSERT INTO message (id,text,fromprofessor, date, horas, Project_id, hasview) VALUES(null, '$text', '$fromprof', CURDATE(), CURTIME(), '$idproject', 'false')";


$result = $mysqli->query($sql);

if ($result)
	echo "1";
else
	echo "0";

?>