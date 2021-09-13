<?php

echo "<title>Courses by Teacher</title>";
@include "../conection_database.php";

$teacherid = 1;

$query = "SELECT id, name FROM course WHERE Professor_id = ".$teacherid;
$result = $mysqli->query($query);

$arrajson = '[';

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arrajson .= '{"id": "'.$row['id'].'", "name": "'.$row['name'].'"  } ';
    $arrajson .= ",";
}

$arrajson = substr( $arrajson, 0, -1);
$arrajson .= "]";

echo $arrajson;
