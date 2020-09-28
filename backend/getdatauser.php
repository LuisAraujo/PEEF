<?php
@include "conection_database.php";
@include "manager_section.php";

$sql = "SELECT name, email, SIS_LANGUAGE.cod FROM STUDENT LEFT JOIN SIS_LANGUAGE ON SIS_LANGUAGE.id = language_id WHERE STUDENT.id = ".getcurrentuser_session();

$result = $mysqli->query($sql);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo json_encode($row);

?>