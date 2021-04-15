<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

//apenas um progress?

$idcourse = 1; //$_POST["idcourse"];

//$sql = "SELECT Count(*) countactivity FROM Activity INNER JOIN Course ON Activity.Course_id = Course.id  WHERE Course.id = '$idcourse'";

$sql = "SELECT Count(*) countactivity FROM Activity INNER JOIN Topic ON Topic.id = Activity.Topic_id INNER JOIN Course ON Topic.Course_id = Course.id  WHERE Course.id = '$idcourse'";


$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$countactivity = $row["countactivity"];

$sql = "SELECT Count(*) countproject FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Course ON Enrollment.Course_id = Course.id  WHERE Enrollment.Student_id = '".getcurrentuser_session()."' AND Course.id = '$idcourse' AND Project.sended = '1'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$countproject = $row["countproject"];

$percent = ($countproject * 100) / $countactivity;

$array = [];
$array["percent"] = number_format((float)$percent, 2, '.', '');

echo json_encode($array);


?>
