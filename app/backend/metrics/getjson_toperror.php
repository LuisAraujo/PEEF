<?php

@include "../conection_database.php";
$idcourse = 2;//$_POST["idcourse"];


$sql = "SELECT typeError, enhancedmessage.subtype as subtype, count(*) as quant FROM `compilation`INNER JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound INNER JOIN Code ON Code.id = Code_id INNER JOIN Project ON Project.id = Code.Project_id INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id WHERE typeError <> \"no-error\" AND Course_id = '$idcourse' GROUP BY typeError, subtype ORDER BY quant DESC";
$result = $mysqli->query($sql);
$arr = [];

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arr[] = $row;
}

echo json_encode($arr);