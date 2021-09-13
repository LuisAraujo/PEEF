<?php

@include "../conection_database.php";
$idcourse = 2;//$_POST["idcourse"];


$sql = "SELECT typeError, erromessage, compMessage, count(*) as quant FROM `compilation`LEFT JOIN enhancedmessage ON enhancedmessage.id = enhancedmessagefound INNER JOIN Code ON Code.id = Code_id INNER JOIN Project ON Code.Project_id = Project.id INNER JOIN Enrollment ON Enrollment.id =  Project.Enrollment_id WHERE  Enrollment.Course_id = '$idcourse' AND typeError <> 'no-error' AND enhancedmessagefound = 0 GROUP BY typeError, subtype ORDER BY quant DESC";
$result = $mysqli->query($sql);
$arr = [];

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

    $row['erromessage']  =  preg_replace( "/\r|\n/", "", $row['erromessage'] );
    $row['compMessage']  =  preg_replace( "/\r|\n/", "", $row['compMessage'] );
    $row['erromessage']  =  str_replace( ",", " ", $row['erromessage'] );
    $row['compMessage']  =  str_replace( ",", "", $row['compMessage'] );


    // $row['compMessage']  =  preg_replace( "/\r\n/", "", $row['compMessage'] );
    // $row['compMessage']  =  str_replace( "\"", "'", $row['compMessage'] );
    //$row["compMessage"] = str_replace( ",", "", $row["compMessage"] );
    // $row["compMessage"]  = str_replace(array("\n", "\r"), '', $row["compMessage"]);
    //$row["compMessage"]  = preg_replace('/[^A-Za-z0-9\-]/', '', $row["compMessage"]);
    // $row["compMessage"]  = "";

    $arr[] = $row;
}

echo json_encode($arr);