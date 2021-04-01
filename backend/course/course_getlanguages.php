<?php

@include "../conection_database.php";

$query = "SELECT id, name FROM Language";

$result = $mysqli->query($query);
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);


?>