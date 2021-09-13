<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$state = $_POST["state"];
$idproject = $_POST["idproject"];

$query = "UPDATE Project SET professor_online = '$state' WHERE id = '$idproject'";
$result = $mysqli->query($query);

if($result){
    echo $query ;
}else{
    echo "0";
}

?>