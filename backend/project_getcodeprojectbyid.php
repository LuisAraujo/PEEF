<?php
@include "conection_database.php";

$idcode = $_POST["idcode"];

$result = $mysqli->query("SELECT code FROM Code Where Code.id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

echo json_encode($row);

return $result;


?>