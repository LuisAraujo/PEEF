<?php

@include "conection_database.php";
@include "manager_section.php";

$sql = "SELECT name FROM COURSE WHERE id = ".getcurrentcourse_session();

$result = $mysqli->query($sql);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo $row["name"];

?>