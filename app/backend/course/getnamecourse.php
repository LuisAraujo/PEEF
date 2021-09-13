<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$sql = "SELECT name FROM course WHERE id = ".getcurrentcourse_session();

$result = $mysqli->query($sql);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo $row["name"];

?>