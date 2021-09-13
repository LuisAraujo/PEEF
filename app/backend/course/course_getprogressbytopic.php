<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

//mudar para getcourse_session
if( isset($_POST["idcourse"]))
    $idcourse = $_POST["idcourse"];
else
    $idcourse = getcurrentcourse_session();

if(isset($_POST["idstudent"]))
    $idstudent = $_POST["idstudent"];
else
    $idstudent = getcurrentuser_session();


$array = array();

$sql = "SELECT id, title FROM Topic WHERE Course_id = ".$idcourse;
$result = $mysqli->query($sql);

while( $row = $result->fetch_assoc()){


    $sql = "SELECT Count(*) countactivity FROM Activity INNER JOIN Topic ON Topic.id = Activity.Topic_id INNER JOIN Course ON Topic.Course_id = Course.id  WHERE Course.id = '$idcourse' AND Topic.id = '".$row["id"]."'";

    $result2 = $mysqli->query($sql);
    $row2 = $result2->fetch_assoc();
    $countactivity = $row2["countactivity"];

    //$sql = "SELECT Count(*) countproject FROM Project INNER JOIN Activity ON Activity.id = Project.Activity_id  INNER JOIN Topic ON Topic.id = Activity.Topic_id  INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Course ON Enrollment.Course_id = Course.id  WHERE Enrollment.Student_id = '".getcurrentuser_session()."' AND Course.id = '$idcourse' AND Project.sended = '1'  AND Topic.id = ".$row["id"];
    $sql = "SELECT Count(*) countproject FROM Project INNER JOIN Activity ON Activity.id = Project.Activity_id  INNER JOIN Topic ON Topic.id = Activity.Topic_id  INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Course ON Enrollment.Course_id = Course.id  WHERE Enrollment.Student_id = '".$idstudent."' AND Course.id = '$idcourse' AND Project.sended = '1'  AND Topic.id = ".$row["id"];
    $result2 = $mysqli->query($sql);

    $row2 = $result2->fetch_assoc();
    $countproject = $row2["countproject"];

    if($countactivity != 0 )
        $percent = ($countproject * 100) / $countactivity;
    else
        $percent = 0;

    $a = [];
    $a["topic"] = $row["title"];
    $a["percent"] = number_format((float)$percent, 2, '.', '');
    array_push($array, $a);
}

echo json_encode($array);