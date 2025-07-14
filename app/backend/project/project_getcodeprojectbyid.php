<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idcode = $_POST["idcode"];
setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT code FROM code Where code.id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

echo json_encode($row);

return $result;


?>