<?php
@include "../conection_database.php";

if(isset( $_POST["idproject"]))
    $idproject = $_POST["idproject"];

$query = "SELECT student.name as sname, course.name as cname, activity.title as title FROM `project` INNER JOIN activity ON project.Activity_id = activity.id  INNER JOIN course_has_activity ON  activity.id = course_has_activity.Activity_id INNER JOIN course ON course.id = course_has_activity.Course_id INNER JOIN Enrollment ON Enrollment.Course_id = Course.id INNER JOIN student ON student.id = enrollment.Student_id WHERE project.id = ".$idproject;

$result = $mysqli->query($query);

if ($result)
    echo json_encode($result->fetch_array(MYSQLI_ASSOC));
else
    echo "0";