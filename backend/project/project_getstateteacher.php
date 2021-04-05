<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$query = "SELECT Project.professor_online FROM Project WHERE Project.id = " . getcurrentproject_session() ;
$result = $mysqli->query($query);

if($result){
    echo json_encode($result->fetch_array(MYSQLI_ASSOC));
}else{
    echo "0";
}

?>