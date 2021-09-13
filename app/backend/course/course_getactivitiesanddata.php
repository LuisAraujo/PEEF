<?php
/*
 * Get list of activity if the current time is less than show after date.
 * This data show in Learner/Course/Activity (Option: Activities).
 * */
@include "../conection_database.php";
@include "../session/manager_section.php";

//select activity * join project (sended) e compilation (sucess) message (chat em view)
//$query = "SELECT id as id_act, title FROM  activity WHERE activity.Course_id = ".getcurrentcourse_session().  " AND (show_after <= CURDATE() OR show_after is NULL) ";

$query = "SELECT Activity.id as id_act, Activity.title, Topic.title as topic  FROM  activity INNER JOIN Topic ON Topic.id = Activity.Topic_id WHERE Topic.Course_id = ".getcurrentcourse_session().  " AND (show_after <= CURDATE() OR show_after is NULL) ORDER BY Topic.id ASC, Activity.id ASC";

//test without curdate (only test)
//$query = "SELECT Activity.id as id_act, Activity.title, Topic.title as topic  FROM  activity INNER JOIN Topic ON Topic.id = Activity.Topic_id WHERE Topic.Course_id = ".getcurrentcourse_session().  "  ORDER BY Topic.id ASC, Activity.id ASC";

$result = $mysqli->query($query);
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){

    $query2 = "SELECT Project.id as id, Compilation.typeError as typeerror, Project.sended as delivered FROM Project LEFT JOIN Code ON Code.Project_id = Project.id LEFT JOIN Compilation ON Compilation.Code_id = Code.id  LEFT JOIN Enrollment ON Project.Enrollment_id = Enrollment.id  WHERE Project.Activity_id = '".$row['id_act']."' AND Enrollment.Student_id = '".getcurrentuser_session()."' ORDER BY Compilation.date DESC, Compilation.hours DESC LIMIT 1";
    $result2 = $mysqli->query($query2);
    $row2 = $result2->fetch_array(MYSQLI_ASSOC);
    if(isset($row2["delivered"]))
        $row["delivered"] = $row2["delivered"];
    else
        $row["delivered"] = 0;

    if(isset($row2["id"]))
        $row["id"] = $row2["id"];
    else
        $row["id"] = NULL;

    if(isset($row2["typeerror"])) {
        if ($row2["typeerror"] == "no-error")
            $row["correct"] = 1;
        else
            $row["correct"] = 0;
    }else{
        $row["correct"] = 0;
    }

    if($row["id"] != NULL) {
        $query3 = "SELECT Count(*) as hasmessage FROM Project INNER JOIN Message ON Message.Project_id = Project.id WHERE Project.id = '" . $row['id'] . "' AND Message.fromprofessor = 1 AND Message.hasview = 0 ORDER BY Message.id DESC LIMIT 1";
        // echo  $query3 ."<br>";
        $result3 = $mysqli->query($query3);
        $row3 = $result3->fetch_array(MYSQLI_ASSOC);

        $row["hasmessage"] = $row3["hasmessage"];
    }else{
        $row["hasmessage"] = 0;
    }
    //if( !isset( $myArray[ $row["topic"] ] ))
    // $myArray[ $row["topic"] ] = array();

    array_push($myArray, $row);
}

echo json_encode($myArray);

?>