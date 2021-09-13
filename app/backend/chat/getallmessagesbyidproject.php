<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

if(isset( $_POST["idproject"]))
    $idproject = $_POST["idproject"];

$query = "SELECT * FROM message WHERE Project_id = $idproject";
$result = $mysqli->query($query);

$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>