<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

//select activity * join project (sended) e compilation (sucess) message (chat em view)
$query = "SELECT id as id_act, title FROM  activity WHERE activity.Course_id = ".getcurrentcourse_session().  " AND (show_after <= CURDATE() OR show_after is NULL) ";
$result = $mysqli->query($query);


$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){

    $query2 = "SELECT Project.id as id, Compilation.typeError as typeerror, Project.sended as delivered FROM Project LEFT JOIN Code ON Code.Project_id = Project.id LEFT JOIN Compilation ON Compilation.Code_id = Code.id  LEFT JOIN Enrollment ON Project.Enrollment_id = Enrollment.id  WHERE Project.Activity_id = '".$row['id_act']."' AND Enrollment.Student_id = '".getcurrentuser_session()."' ORDER BY Compilation.date DESC, Compilation.hours DESC LIMIT 1";
    $result2 = $mysqli->query($query2);
    $row2 = $result2->fetch_array(MYSQLI_ASSOC);

    $row["delivered"] = $row2["delivered"];
    $row["id"] = $row2["id"];

    if($row2["typeerror"] == "no-error")
        $row["correct"] = 1;
    else
        $row["correct"] = 0;

    $query3 = "SELECT Count(*) as hasmessage FROM Project INNER JOIN Message ON Message.Project_id = Project.id WHERE Project.id = '".$row['id']."' AND Message.fromprofessor = 1 AND Message.hasview = 0 ORDER BY Message.id DESC LIMIT 1";
   // echo  $query3 ."<br>";
    $result3 = $mysqli->query($query3);
    $row3 = $result3->fetch_array(MYSQLI_ASSOC);

    $row["hasmessage"] = $row3["hasmessage"];

    array_push($myArray, $row);
}

echo json_encode($myArray);

?>