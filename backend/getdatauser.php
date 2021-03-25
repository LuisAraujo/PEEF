<?php
@include "conection_database.php";
@include "session/manager_section.php";

$sql = "SELECT name, email, sis_language.cod FROM student LEFT JOIN sis_language ON sis_language.id = language_id WHERE student.id = ".getcurrentuser_session();

$result = $mysqli->query($sql);

$row = $result->fetch_array(MYSQLI_ASSOC);

echo json_encode($row);

?>