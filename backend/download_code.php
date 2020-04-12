<?php
@include "conection_database.php";
@include "manager_section.php";

$idcode = $_GET["idcode"];

setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT name, code FROM Code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

$tmpfname = tempnam("../codes", "CODE_");
$handle = fopen($tmpfname, "w");
fwrite($handle, $row["code"]);
fclose($handle);


# send the file to the browser as a download
header('Content-disposition: attachment; fileName='.$row["name"]);
header('Content-type: application/py');
readfile($tmpfname);

?>