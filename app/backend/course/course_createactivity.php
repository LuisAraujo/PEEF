<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idtopic = $_POST["idtopic"];
$activityname = $_POST["activityname"];
$description = $_POST["description"];
$descriptionin = $_POST["descriptionin"];
$descriptionout = $_POST["descriptionout"];
$datadelivery = $_POST["datadelivery"];
$datashow = $_POST["datashow"];
$inputs = $_POST["inputs"];
$idtopic = $_POST["idtopic"];



//$sql = "INSERT INTO Activity (id,description,title,description_input,description_output, date_creation, data_delivery, image, Course_id)  VALUES(null, '$activityname', '$description', '$descriptionin', '$descriptionout', CURDATE(), '$datadelivery', '', '$idcourses')";
//ACTIVITY N TEM MAIS ID COURSE _ MUDAR 
$sql = "INSERT INTO Activity (id,title,description,description_input,description_output, date_creation, data_delivery, show_after, image, Topic_id)  VALUES(null, '$activityname', \"".$description."\" ,  \"".$descriptionin."\",  \"".$descriptionout."\", CURDATE(), '$datadelivery', '$datashow','', '$idtopic')";

$result = $mysqli->query($sql);




if (!$result) {
    echo "0";
    echo $sql;
    return;
}


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

    if(!$result2) {
        echo "0";
        return;
    }
}



if ($result)
    echo "1";
 else
    echo  "0";



?>
