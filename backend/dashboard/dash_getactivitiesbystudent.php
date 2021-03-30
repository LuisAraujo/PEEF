<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idstudent = $_POST["idstudent"];


$query = "SELECT Project.id as id, Activity.id as idactivity, Activity.title as title FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id INNER JOIN Activity ON Activity.id = Project.Activity_id  WHERE Enrollment.Student_id = '$idstudent'";

$result = $mysqli->query($query);
$myArray = array();

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

    $query2 = "SELECT count(*) as compilation FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = " . $row["id"];
    $result2 = $mysqli->query($query2);
    $row["compilation"] = $result2->fetch_assoc()["compilation"];

    $query3 = "SELECT count(*) as passedtest FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = " . $row["id"]. " AND Compilation.testpassed <> -1 ";
    $result3 = $mysqli->query($query3);
    $row["test"] = $result3->fetch_assoc()["passedtest"];

    $query4 = "SELECT Compilation.id as idpassed, compilation.testpassed as passed FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id =  '" . $row["id"] . "' AND compilation.testpassed <> -1 ORDER BY Compilation.date DESC, Compilation.hours DESC LIMIT 1";
    $result4 = $mysqli->query($query4);
    $assoc = $result4->fetch_assoc();
    $row["passed"] = $assoc["passed"];
    $row["idpassed"] = $assoc["idpassed"];

    $query5 = "SELECT count(*) as complitaion FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = '" . $row["id"] . "' AND Compilation.typeError <> 'no-error'";
    $result5 = $mysqli->query($query5);
    $row["error"] = $result5->fetch_assoc()["complitaion"];


    $query6 = "SELECT Compilation.id as idcomp, Compilation.typeError as typeerror FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = '" . $row["id"] . "' ORDER BY Compilation.date DESC, Compilation.hours DESC LIMIT 1";
    $result6 = $mysqli->query($query6);
    $assoc = $result6->fetch_assoc();
    $row["typeerror"] = $assoc ["typeerror"];
    $row["idcomp"] = $assoc ["idcomp"];

    $query7 = "SELECT Count(*) as unviewed FROM Message WHERE Project_id = '" . $row["id"] . "' AND hasview = 0 AND fromprofessor = 0";
    $result7 = $mysqli->query($query7);
    $row["unviewed"] = $result7->fetch_assoc()["unviewed"];

    array_push($myArray, $row);
}


echo json_encode($myArray);


?>