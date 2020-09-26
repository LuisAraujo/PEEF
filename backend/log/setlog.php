<?php
@include "../conection_database.php";
@include "../manager_section.php";

$action = $_POST["action"];
$idref = "";

if ( strcmp($action , "oncourse") || strcmp($action , "offcourse"))
    $idref = getcurrentcourse_session();
else if(strcmp($action , "onproject") || strcmp($action , "offproject"))
    $idref = getcurrentproject_session();
else
    $idref = -1;

$query2 = "INSERT INTO Log (id, Action_id, Student_id, date, hours, id_ref) ";
$query2 .= " VALUES (NULL,(SELECT id FROM Action WHERE nome = '$action') ," . getcurrentuser_session(). ", CURDATE(), CURTIME(), '$idref' )";
$result2 = $mysqli->query($query2);

echo $query2;

?>