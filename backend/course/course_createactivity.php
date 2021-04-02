<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourses = $_POST["idcourses"];
$activityname = $_POST["activityname"];
$description = $_POST["description"];
$descriptionin = $_POST["descriptionin"];
$descriptionout = $_POST["descriptionout"];
$datadelivery = $_POST["datadelivery"];
$inputs = $_POST["inputs"];


$sql = "INSERT INTO Activity (id,description,title,description_input,description_output, date_creation, data_delivery,     image, Course_id)  VALUES(null, '$activityname', '$description', '$descriptionin', '$descriptionout', CURDATE(), '$datadelivery', '', '$idcourses')";
$result = $mysqli->query($sql);

$sql2 ="SELECT LAST_INSERT_ID() as id ";
$result2 = $mysqli->query($sql2);
$row = $result2->fetch_assoc();

for($i = 0; $i < count($inputs); $i++) {
    $inp = $inputs[$i];
    $str = "";
    for($j  = 0; $j < count($inp)-1; $j++) {
        $str .=  $inp[$j]."\\n";
    }
    $str2 =  $inp[$j];

    $sql3 = "INSERT INTO test (id, input, output, Activity_id) VALUE(NULL, '$str','$str2', '".$row["id"]."' )";
    $result2 = $mysqli->query($sql3);

    if(!$result2)
        echo "0";
}

if ($result)
    echo "1";
 else
    echo  "0";



?>
