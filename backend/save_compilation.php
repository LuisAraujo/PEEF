<?php

//$idproject = $_SESSION["project"];

$idcode = $_POST["idcode"];
//Initial value
$line = "";
$typeerror = "";

if($error != 0){

    /* $typeerror = $out[ count($out) - 1];
    if($typeerror == "SyntaxError: invalid syntax")
        $line = explode(",", $out[ count($out) - 4])[1];
    else
        $line = explode(",", $out[ count($out) - 3])[1];
    */
    //unset($out[0]);

    $typeerror = str_replace("'" , "\'" , implode(",",$out));
}

//Insert Compilations
$query = "INSERT compilation VALUES (null, CURDATE() , CURTIME(),'".$line." , ".$typeerror." ',  $idcode)";
$result = $mysqli->query($query);

$code2 = str_replace("'" , "\'" , $row[code]);

//Copying Code in Compilations
$query2 = "INSERT CodeCompilation VALUES (null, '".$row[name]."',' ".$code2." ', $mysqli->insert_id )";
$result2 = $mysqli->query($query2);

?>