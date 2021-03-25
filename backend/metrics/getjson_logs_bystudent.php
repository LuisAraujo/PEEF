<?php

echo "<title>Engagement By Student</title>";
@include "../conection_database.php";

$studentid = 1;
//$query = "SELECT action.name as name, log.date as date, hours FROM LOG INNER JOIN action ON LOG.Action_id = ACTION.id WHERE Student_id = 1";
$query = "(SELECT action.name as name, log.date as date, hours, id_ref as ref FROM LOG INNER JOIN action ON LOG.Action_id = ACTION.id WHERE Student_id = 1) UNION (SELECT CASE WHEN typeError = '' THEN 'sucess' ELSE 'error' END AS name, date, hours, Code_id as ref FROM compilation WHERE Code_id = (SELECT DISTINCT Code_id FROM code INNER JOIN compilation ON Code_id = code.id INNER JOIN project ON code.Project_id = project.id  INNER JOIN enrollment ON project.Enrollment_id = enrollment.id WHERE Student_id = 1 )) ORDER BY date ASC, hours ASC";
$result = $mysqli->query($query);

$arrajson = '[';

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arrajson .= '{"name": "'.$row['name'].'", "date": "'.$row['date'].'", "hours":"'.$row['hours'].'", "ref":"'.$row['ref'].'" } ';
    $arrajson .= ",";
}

$arrajson = substr( $arrajson, 0, -1);
$arrajson .= "]";

echo $arrajson;

?>
