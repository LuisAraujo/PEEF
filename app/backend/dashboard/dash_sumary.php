<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

if(getcurrentcourse_session() == "-1") {
    echo "[]";
    exit();

}else {
    $arr = [];

    $query = "SELECT count(*) as student FROM Enrollment WHERE Course_id = " . getcurrentcourse_session();

    $result = $mysqli->query($query);
    $arr["student"] = $result->fetch_assoc()["student"];


    $query2 = "SELECT count(*) as activity FROM Activity INNER JOIN Topic On Topic.id = Activity.Topic_id WHERE Topic.Course_id = " . getcurrentcourse_session();
    //todo:
    //$query2 = "SELECT count(*) as activity FROM Activity WHERE Course_id = " . getcurrentcourse_session();

    $result = $mysqli->query($query2);
    $arr["activity"] = $result->fetch_assoc()["activity"];

    $query3 = "SELECT count(*) as classes FROM  Classes WHERE Course_id = " . getcurrentcourse_session();
    $result = $mysqli->query($query3);
    $arr["classes"] = $result->fetch_assoc()["classes"];

    $query4 = "SELECT count(*)as complitaion FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = " . getcurrentcourse_session(). " AND compilation.testpassed = -1";
    $result = $mysqli->query($query4);
    $arr["complitaion"] = $result->fetch_assoc()["complitaion"];

    $query5 = "SELECT count(*) as test FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = " . getcurrentcourse_session() . " AND compilation.testpassed <> -1";
    $result = $mysqli->query($query5);
    $arr["test"] = $result->fetch_assoc()["test"];


    $query6 = "SELECT count(*) as passedtest FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN enrollment ON enrollment.id = project.Enrollment_id WHERE enrollment.Course_id = " . getcurrentcourse_session() . " AND compilation.testpassed = 1";
    $result = $mysqli->query($query6);
    $arr["passedtest"] = $result->fetch_assoc()["passedtest"];


    echo json_encode($arr);
}