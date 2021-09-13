<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourse = $_POST["idcourse"];
$idstudent = $_POST["idstudent"];


//get leste result os test

$query = "SELECT Project.id as id, Project.Activity_id as idactivity FROM project INNER JOIN enrollment ON enrollment_id = enrollment.id INNER JOIN student ON Student_id = student.id WHERE Enrollment.Student_id = '" . $idstudent . "'";
$result = $GLOBALS['mysqli']->query($query);

$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){


    $query2 = "SELECT Compilation.id as idpassed, compilation.testpassed as passed FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id =  '" . $row["id"] . "' AND compilation.testpassed <> -1 ORDER BY Compilation.date DESC, Compilation.hours DESC LIMIT 1";
    $result2 = $mysqli->query($query2);
    $row2 = $result2->fetch_assoc();
    $row["passed"] = $row2["passed"];

    if(isset($row2["typeerror"])) {
        if ($row2["typeerror"] == "no-error")
            $row["correct"] = 1;
        else
            $row["correct"] = 0;
    }

    array_push($myArray, $row);
}

echo json_encode($myArray);

