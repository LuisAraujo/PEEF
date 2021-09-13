<?php

@include "../metrics/calc_stringedit.php";
@include "../conection_database.php";
@include "../session/manager_section.php";

global $mysqli;

function getSolution(){

    $query = "SELECT Compilation.typeerror,  Compilation.erromessage FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id  INNER JOIN Project ON Project.id = Code.Project_id WHERE Project.id = ".  getcurrentproject_session()." ORDER BY Compilation.id DESC LIMIT 1";

    $result = $GLOBALS['mysqli']->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $subtypeError = $row["erromessage"];
    $local = false;


    if($result){


        $query = "SELECT id, text, type, subtype FROM solution WHERE type LIKE '%". $row["typeerror"]."%'  AND Sis_Language_id = (SELECT Language_id FROM student WHERE  id = '".getcurrentuser_session()."') AND Language_id = (SELECT Language_id FROM course WHERE id = '".getcurrentcourse_session()."')";
        $ret = "";
        $result = $GLOBALS['mysqli']->query($query);

        $error = "";
        $find = false;
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $typeOriginal = $subtypeError;

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
                $local = strpos($subtypeError , $strfind);


                if($local !== false){
                    //removing string match to not mistake next find
                    $newstr = substr($subtypeError, 0, $local );
                    $newstr .=  substr($subtypeError, $local+strlen($strfind), strlen($subtypeError)-$local );
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
            $subtypeError = $typeOriginal;
        }

        //$local = editDistDP($row["subtype"], $typeError[2], strlen($row["subtype"]), strlen($typeError[2]));
        if($local !== false){
            $error = "#".$row["id"]. " ". $row["text"];
        }else{
            $error = $ret;
        }

        return $error;


    }else{
        echo "0";
    }



}

echo getSolution();