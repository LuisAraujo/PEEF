<?php
@require_once "../conection_database.php";
@include "calc_errormetrics.php";

/*change to get all RED of students in course*/

$idactivity = 5;
$idstudent = 1;

echo getjsonRED($idactivity, $idstudent);

function getjsonRED($idactivity)
{
    $array = array();
    $array["activity"] = $idactivity;
    $array["students"] = array();

    $query = "SELECT Enrollment.Student_id as id FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id WHERE Project.Activity_id =" . $idactivity;
    $result = $GLOBALS['mysqli']->query($query);

    while ($row = $result->fetch_assoc()) {

        $array2 = array();
        $array2["id"] = $row["id"];
        $array2["projects"] = array();

        $query2 = "SELECT Project.id as id FROM project INNER JOIN enrollment ON enrollment_id = enrollment.id INNER JOIN student ON Student_id = student.id WHERE Activity_id ='" . $idactivity . "' AND Enrollment.Student_id = '" . $row["id"] . "'";
        $result2 = $GLOBALS['mysqli']->query($query2);
        while ($row2 = $result2->fetch_assoc()) {
            $array3 = array();
            $array3["id"] = $row2["id"];
            $array3["score"] = getRED($row["id"], $row2["id"]);
            $array2["projects"][] = $array3;
        }

        $array["students"] = $array2;
    }

    return json_encode($array);
}