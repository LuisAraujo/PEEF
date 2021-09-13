<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

if( isset($_POST["idcourse"]) )
    $idcourse = $_POST["idcourse"];
else
    $idcourse = getcurrentcourse_session();

$array = array();

$sql = "SELECT id, title, text, date FROM Alert WHERE Course_id = ".$idcourse." ORDER BY date DESC";

$result = $mysqli->query($sql);

while( $row = $result->fetch_assoc()){
    $array[] = $row;
}

echo json_encode($array);