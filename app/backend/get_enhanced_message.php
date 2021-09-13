<?php
//ir para run code


@include "metrics/calc_stringedit.php";
@include "conection_database.php";
@include "session/manager_section.php";

function getEnhancedMessage($typeError){

    $query = "SELECT id, subtype, enhancedmessage FROM enhancedmessage WHERE type LIKE '%".$typeError[0]."%' AND Sis_Language_id = (SELECT Language_id FROM student WHERE  id = '".getcurrentuser_session()."') AND Language_id = (SELECT Language_id FROM course WHERE id = '".getcurrentcourse_session()."')";
    $ret = "";
    $result = $GLOBALS['mysqli']->query($query);
    $local = false;
    $error = "";
    $find = false;
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $typeOriginal = $typeError[2];

        //old find mode
        //$local = strpos( $typeError[2], $row["subtype"]);

        //split string in _
        $subtype_split = explode("_", $row["subtype"]);

        $local = false;
        for ($i = 0; $i < count($subtype_split); $i++){

            $value = $subtype_split[$i];
            //removing spaces
            $strfind = ltrim($value);
            $strfind = rtrim($strfind);
            //contains?
            $local = strpos($typeError[2], $strfind);


            if($local !== false){
                //removing string match to not mistake next find
                $newstr = substr($typeError[2], 0, $local );
                $newstr .=  substr($typeError[2], $local+strlen($strfind), strlen($typeError[2])-$local );
                $typeError[2] = $newstr;

                //if is the last interation and local is true, find
                if($i == count($subtype_split)-1){
                    $find = true;
                }

            }else{
                $i = count($subtype_split);
            }
        }

        //find all elements in message?
        if( $find )
            break;

        //replace typeerro to next check
        $typeError[2] = $typeOriginal;
    }

    //$local = editDistDP($row["subtype"], $typeError[2], strlen($row["subtype"]), strlen($typeError[2]));
    if($local !== false){
        $error = [ $row["id"] , "#".$row["id"]. " ". $row["enhancedmessage"]];
    }else{
        $error = [0, $ret];
    }

    return $error;
}

