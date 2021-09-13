<?php

$line = "";
$errormessage = "";
$typeerror = ['no-error','-1'];

if($error != 0){

    if( is_array($out))
        $imp_str = implode(",",$out);
    else
        $imp_str = $out;

    $errormessage = preg_replace( "/\r|\n/", ",", $imp_str );
    $errormessage = str_replace( ",,", ",", $imp_str );
    $errormessage = str_replace("\\" , "\\\\" , $errormessage);
    $errormessage = str_replace("'" , "\'" , $errormessage );

    $typeerror = checkErroType($errormessage);

}

//verificar se n causa erro
if($error != 0)
    $testpassed = 0;
else
    $testpassed = $n_error==0?1:0;

//Insert Compilations
$query = "INSERT compilation VALUES (NULL, CURDATE() , CURTIME(), '$errormessage',  $idcode, '$typeerror[0]', '$typeerror[1]', '', '$testpassed', 0, '$jsontest')";

$result = $mysqli->query($query);

$code2 = str_replace("'" , "\'" , $row['code']);

//Copying Code in Compilations
$query2 = "INSERT codecompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $mysqli->insert_id )";
$result2 = $mysqli->query($query2);

?>