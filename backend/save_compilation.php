<?php

$line = "";
$errormessage = "";

if($error != 0){

    if( is_array($out))
        $imp_str = implode(",",$out);
    else
        $imp_str = $out;

    $errormessage = preg_replace( "/\r|\n/", ",", $imp_str );
    $errormessage = str_replace( ",,", ",", $imp_str );
    $errormessage = str_replace("\\" , "\\\\" , $errormessage);
    $errormessage = str_replace("'" , "\'" , $errormessage );

}

if($error != 0)
    $testpassed = -1;
else
    $testpassed = $n_error==0?1:0;
//Insert Compilations
$query = "INSERT compilation VALUES (NULL, CURDATE() , CURTIME(), '$errormessage',  $idcode, NULL, NULL, NULL, $testpassed)";

$result = $mysqli->query($query);

$code2 = str_replace("'" , "\'" , $row['code']);

//Copying Code in Compilations
$query2 = "INSERT CodeCompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $mysqli->insert_id )";
$result2 = $mysqli->query($query2);

?>