<?php

@include "metrics/calc_stringedit.php";
@include "conection_database.php";

//echo getEnchecedMessage( ["SyntaxError", "0", "invalid syntax"]);

function getEnchecedMessage($typeError, $idcode){

    $query = "SELECT subtype, enhancedmessage FROM ENHANCEDMESSAGE WHERE type = '$typeError[0]'";
    //echo $query;
    $result = $GLOBALS['mysqli']->query($query);

    $min = 99999999;
    $error = "";

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        //get edit dif
        $localmin = editDistDP($row["subtype"], $typeError[2], strlen($row["subtype"]), strlen($typeError[2]));
        if($localmin  < $min){

            $min= $localmin;
            $error = $row["enhancedmessage"];
        }

    }

    return $error;
}

