<?php

/*Calcula a métrica para o RED*/
@require_once "../conection_database.php";

function getRED($idstudent, $idproject){
    $lastErro = "";
    $EQ = 0;
    $repeat_error = 0;

    $query = "SELECT typeError FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id INNER JOIN Student ON Enrollment.Student_id = Student.id WHERE Student.id = ".$idstudent." AND Project.id =".$idproject. " ORDER BY Compilation.date ASC, Compilation.hours ASC";
    $result = $GLOBALS['mysqli']->query($query);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($lastErro == "") {
            $lastErro = $row["typeError"];
            continue;
        }

        if ($lastErro == $row["typeError"]) {
            $repeat_error++;
        } else {

            $EQ += ($repeat_error * $repeat_error) / ($repeat_error + 1);

            $repeat_error= 0;
        }

        $lastErro = $row["typeError"];

    }
    return $EQ;
}
