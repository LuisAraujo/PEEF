<?php

@include "../conection_database.php";
@include "../session/manager_section.php";


if(gettypeuser() != 2){
    return 0;
}

if(isset( $_POST["idproject"]))
    $idproject = $_POST["idproject"];


$query = "SELECT Project.id as id FROM Project INNER JOIN Activity ON Activity.id = Project.Activity_id  INNER JOIN Course ON Course.id = Activity.Course_id INNER JOIN Professor ON Course.Professor_id = Professor.id WHERE Project.id = '$idproject' AND Professor.id = ".getcurrentuser_session();
//$query = "SELECT Project.id as id FROM Project INNER JOIN Activity ON Activity.id = Project.Activity_id INNER JOIN Course_Has_Activity ON Activity.id = Course_Has_Activity.Activity_id INNER JOIN Course ON Course.id = Course_Has_Activity.Course_id INNER JOIN Professor ON Course.Professor_id = Professor.id WHERE Project.id = '$idproject' AND Professor.id = ".getcurrentuser_session();

$result = $mysqli->query($query);

if($result){
    echo $result->fetch_assoc()["id"];
}else{
    echo $query;
}



?>