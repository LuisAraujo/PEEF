<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

//apenas um progress?

$idcourse = $_POST["idcourses"];

//$sql = "SELECT Count(*) countactivity FROM Activity INNER JOIN Course ON Activity.Course_id = Course.id  WHERE Course.id = '$idcourse'";

$sql = "SELECT Count(*) countactivity, Course.name as coursename, Course.code as coursecode FROM Activity INNER JOIN Topic ON Topic.id = Activity.Topic_id INNER JOIN Course ON Topic.Course_id = Course.id  WHERE Course.id = '$idcourse'";


$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$countactivity = $row["countactivity"];
$coursename = $row["coursename"];

$sql = "SELECT Count(*) countproject FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Course ON Enrollment.Course_id = Course.id  WHERE Enrollment.Student_id = '".getcurrentuser_session()."' AND Course.id = '$idcourse' AND Project.sended = '1'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$countproject = $row["countproject"];

if($countactivity != 0)
    $percent = ($countproject * 100) / $countactivity;
else
    $percent = 0;
$array = [];
$array["percent"] = number_format((float)$percent, 2, '.', '');


echo json_encode($array);


?>
