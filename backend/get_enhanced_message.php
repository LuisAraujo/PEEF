<?php
//ir para run code


@include "metrics/calc_stringedit.php";
@include "conection_database.php";
@include "session/manager_section.php";

function getEnhancedMessage($typeError){

    $query = "SELECT subtype, enhancedmessage FROM enhancedmessage WHERE type = '$typeError[0]' AND Sis_Language_id = (SELECT Language_id FROM student WHERE  id = '".getcurrentuser_session()."') AND Language_id = (SELECT Language_id FROM course WHERE id = '".getcurrentcourse_session()."')";

    $result = $GLOBALS['mysqli']->query($query);

    $error = "";

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        //get edit dif
        $local = strpos($typeError[2], $row["subtype"]);

        //$local = editDistDP($row["subtype"], $typeError[2], strlen($row["subtype"]), strlen($typeError[2]));
        if($local !== false){
            $error = $row["enhancedmessage"];
            break;
        }

    }

    return $error;
}

