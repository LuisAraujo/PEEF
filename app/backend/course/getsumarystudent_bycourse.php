<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$courseid = getcurrentcourse_session();
if($courseid == "-1"){
    echo "[]";
    exit();
}else {
    $query = "SELECT enrollment.id as enrollment, Student.id, Student.name FROM enrollment INNER JOIN Student ON Student.id = Student_id WHERE Course_id = " . $courseid;
    $result = $mysqli->query($query);

    $arrajson = '[';


    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $query2 = "SELECT Count(*) as compilation FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE Enrollment.id = " . $row["enrollment"]. " AND Compilation.testpassed = '-1'";

        $query3 = "SELECT Count(*) as errorcomp FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE compilation.typeError != 'no-error' AND Enrollment.id = " . $row["enrollment"];

        //todo: precisa pegar apenas a ultima compilacao
        $query4 = "SELECT Count(*) as passed FROM Compilation INNER JOIN Code ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE compilation.testpassed != '-1' AND Enrollment.id = " . $row["enrollment"];


        $query5 = "SELECT Count(*) as delivery  FROM Project  INNER JOIN Enrollment ON Project.Enrollment_id = Enrollment.id WHERE Project.sended = '1' AND Enrollment.id = " . $row["enrollment"];

        //todo: precisa pegar as atvs entregues
        $query6 = "SELECT Count(*) as projectstarted  FROM Project WHERE Project.Enrollment_id = " . $row["enrollment"];

        $query7 = "SELECT Action_id, date, hours FROM `log` WHERE `Action_id` <= 6 AND Enrollment_id = " . $row["enrollment"] . " ORDER BY date DESC, hours DESC LIMIT 1";


        $result2 = $mysqli->query($query2);
        $result3 = $mysqli->query($query3);
        $result4 = $mysqli->query($query4);
        $result5 = $mysqli->query($query5);
        $result6 = $mysqli->query($query6);
        $result7 = $mysqli->query($query7);


        $row2 = $result2->fetch_array(MYSQLI_ASSOC);
        $row3 = $result3->fetch_array(MYSQLI_ASSOC);
        $row4 = $result4->fetch_array(MYSQLI_ASSOC);
        $row5 = $result5->fetch_array(MYSQLI_ASSOC);
        $row6 = $result6->fetch_array(MYSQLI_ASSOC);
        $curhours = null;
        $hours = null;
        $valcurhours = null;
        $valhours = null;

        if($result7->num_rows != 0) {
            $row7 = $result7->fetch_array(MYSQLI_ASSOC);

            if (strcmp($row7['date'], date("Y-m-d")) == 0) {
                $curhours = explode("-", date("H-i-s"));
                $valcurhours= intval($curhours[0]) * 60 * 60 + intval($curhours[1]) * 60 + intval($curhours[2]);
                $hours = explode(":", $row7['hours']);
                $valhours = intval($hours[0]) * 60 * 60 + intval($hours[1]) * 60 + intval($hours[2]);
                $bias = 2 * 60 * 60;

                if ($valcurhours - $valhours < 4000 + $bias)
                    $online = (intval($row7['Action_id']) % 2);
                else
                    $online = 0;
            } else
                $online = 0;
        }else
            $online = 0;

        $arrajson .= '{"id": "' . $row['id'] . '", "name": "' . $row['name'] . '" , "compilation": "' . $row2['compilation'] . '",  "error": "' . $row3['errorcomp'] . '" , "passed": "' . $row4['passed'] . '", "delivery": "' . $row5['delivery'] . '", "projectstarted": "' . $row6['projectstarted'] . '", "online": "'. $online .'"} ';
        $arrajson .= ",";
    }

    $arrajson = substr($arrajson, 0, -1);
    $arrajson .= "]";

    echo $arrajson;
}
?>