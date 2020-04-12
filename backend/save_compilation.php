<?php

//$idproject = $_SESSION["project"];


//Initial value
$line = "0";
$typeerror = "no-error";

if($error != 0){
    $line = explode(",", $out[ count($out) - 3])[1];
    $typeerror = $out[ count($out) - 1];
    $typeerror = str_replace("'" , "\'" , $typeerror);
}

//Insert Compilations
$query = "INSERT compilation VALUES (null, CURDATE() , CURTIME(),'".$line." , ".$typeerror." ', ". getcurrentproject_session() .")";
$result = $mysqli->query($query);

$code2 = str_replace("'" , "\'" , $row[code]);

//Copying Code in Compilations
$query2 = "INSERT CodeCompilation VALUES (null, '".$row[name]."' , ' ".$code2." ', $mysqli->insert_id )";
$result2 = $mysqli->query($query2);

?>