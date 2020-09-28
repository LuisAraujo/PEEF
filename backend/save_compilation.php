<?php

$line = "";
$typeerror = "";

if($error != 0){

    if( is_array($out))
        $imp_str = implode(",",$out);
    else
        $imp_str = $out;

    $typeerror = preg_replace( "/\r|\n/", ",", $imp_str );
    $typeerror = str_replace( ",,", ",", $imp_str );
    $typeerror = str_replace("\\" , "\\\\" , $typeerror);
    $typeerror = str_replace("'" , "\'" , $typeerror );

}

if($error != 0)
    $testpassed = -1;
else
    $testpassed = $n_error==0?1:0;
//Insert Compilations
$query = "INSERT compilation VALUES (NULL, CURDATE() , CURTIME(), '$typeerror',  $idcode, NULL, NULL, $testpassed)";

$result = $mysqli->query($query);

$code2 = str_replace("'" , "\'" , $row['code']);

//Copying Code in Compilations
$query2 = "INSERT CodeCompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $mysqli->insert_id )";
$result2 = $mysqli->query($query2);

?>