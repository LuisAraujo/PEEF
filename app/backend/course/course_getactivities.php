<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

//select activity * join project (sended) e compilation (sucess) message (chat em view)
//$query = "SELECT * FROM  activity WHERE activity.Course_id = ".getcurrentcourse_session();
//todo: add topics

$query = "SELECT * FROM  activity INNER JOIN Topic ON Topic.id = Activity.Topic_id WHERE Topic.Course_id = ".getcurrentcourse_session();

$result = $mysqli->query($query);

$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)){
    array_push($myArray, $row);
}

echo json_encode($myArray);

?>