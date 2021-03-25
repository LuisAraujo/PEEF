<?php
@include "conection_database.php";
@include "session/manager_section.php";

$name = $_POST["name"];
$extension = $_POST["extension"];

$result = $mysqli->query("INSERT INTO code VALUES('null', '$name". "." . "$extension', '', " . getcurrentproject_session(). ")" );

if($result)
    echo "ok";
else
    echo "erro";






?>