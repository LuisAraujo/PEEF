<?php
//essa query está com problmea pois está buscando dados de mais de um codigo dentro da subquery

@include "../conection_database.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];

$query = "(SELECT action.name as name, log.date as date, hours, id_ref as ref FROM LOG INNER JOIN action ON LOG.Action_id = ACTION.id WHERE  Log.Enrollment_id = (SELECT id FROM Enrollment WHERE Enrollment.Student_id = '".$idstudent."' AND Enrollment.Course_id = '".$idcourse."') ) UNION (SELECT CASE WHEN typeError = '' THEN 'sucess' ELSE 'error' END AS name, date, hours, Code_id as ref FROM compilation WHERE Code_id = (SELECT DISTINCT Code_id FROM code INNER JOIN compilation ON Code_id = code.id INNER JOIN project ON code.Project_id = project.id  INNER JOIN enrollment ON project.Enrollment_id = enrollment.id WHERE Student_id = '".$idstudent."' )) ORDER BY date ASC, hours ASC";
$result = $mysqli->query($query);
echo $query ;
$arrajson = '[';

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $arrajson .= '{"name": "'.$row['name'].'", "date": "'.$row['date'].'", "hours":"'.$row['hours'].'", "ref":"'.$row['ref'].'" } ';
    $arrajson .= ",";
}

$arrajson = substr( $arrajson, 0, -1);
$arrajson .= "]";

echo $arrajson;

?>
