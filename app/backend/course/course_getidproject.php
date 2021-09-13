<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$activity = $_POST['idactivity'];

$query = "SELECT project.id as id FROM project WHERE project.Activity_id = $activity AND project.Enrollment_id = (SELECT id FROM enrollment WHERE Student_id = " . getcurrentuser_session() . " AND Course_id = " . getcurrentcourse_session(). ")" ;

$result = $mysqli->query($query);

if( $result->num_rows ==  0  ) {

    $query2 = "INSERT INTO project (id, creationdate, date_lastmodification, hours_lastmodification, enhancedmessage, sended, iscorret, Enrollment_id, Activity_id, Estado_idEstado)";
    $query2 .= " VALUES (NULL, CURDATE(), CURDATE(), CURRENT_TIME(), 0, 0, NULL, (SELECT id FROM enrollment WHERE Student_id = " . getcurrentuser_session() . " AND Course_id = " . getcurrentcourse_session() . ") , $activity, 1)";
    $result2 = $mysqli->query($query2);

    setcurrentproject_session($mysqli->insert_id);
    echo json_encode("{'id' : '".$mysqli->insert_id."'}");


}else{

    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($row);
}


?>