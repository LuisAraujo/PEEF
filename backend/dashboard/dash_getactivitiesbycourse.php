<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

if(getcurrentcourse_session() == "-1"){
    echo "[]";
    exit();
}else {
    $query = "SELECT Activity.id as id, Activity.title as title FROM Activity WHERE Activity.Course_id = " . getcurrentcourse_session();

    $result = $mysqli->query($query);
    $myArray = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $query2 = "SELECT count(*) as compilation FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN Activity ON Activity.id = project.Activity_id WHERE Activity.id = " . $row["id"];
        $result2 = $mysqli->query($query2);
        $row["compilation"] = $result2->fetch_assoc()["compilation"];

        $query3 = "SELECT count(*) as passedtest FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN  Activity ON Activity.id = project.Activity_id WHERE Activity.id = '" . $row["id"] . "' AND Compilation.testpassed <> -1 ";
        $result3 = $mysqli->query($query3);
        $row["test"] = $result3->fetch_assoc()["passedtest"];

        $query4 = "SELECT count(*) as passedtest FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN  Activity ON Activity.id = project.Activity_id WHERE Activity.id = '" . $row["id"] . "' AND Compilation.testpassed = 1 ";
        $result4 = $mysqli->query($query4);
        $row["passed"] = $result4->fetch_assoc()["passedtest"];

        $query5 = "SELECT count(*) as complitaion FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  INNER JOIN Activity ON Activity.id = project.Activity_id WHERE Activity.id = '" . $row["id"] . "' AND Compilation.typeError <> 'no-error'";
        $result5 = $mysqli->query($query5);
        $row["error"] = $result5->fetch_assoc()["complitaion"];

        array_push($myArray, $row);
    }


    echo json_encode($myArray);

}
?>