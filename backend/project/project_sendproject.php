<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

if(isset( $_POST["sended"]))
    $sended = $_POST["sended"];

$query = "UPDATE project SET sended = '$sended' WHERE id = " . getcurrentproject_session() ;
$result = $mysqli->query($query);

if($result){
    echo "1";
}else{
    echo "0";
}

?>