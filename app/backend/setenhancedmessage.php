<?php
/*Only for consulting type erros without enhanced message. */

@include "conection_database.php";


$query = "SELECT id, typeError, erromessage FROM `compilation` Where typeError <> 'no-error' and enhancedmessagefound = 1";
$result =$mysqli->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {



    $query = "SELECT id, subtype, enhancedmessage FROM enhancedmessage WHERE Type LIKE '%" . $row['typeError'] . "%' AND Sis_Language_id = 2";
    $ret = "";
    $result2 = $mysqli->query($query);

    $error = "";
    $find = false;
    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
        $typeOriginal = $row["erromessage"];

        //old find mode
        //$local = strpos( $typeError[2], $row["subtype"]);

        //split string in _
        $subtype_split = explode("_", $row2["subtype"]);

        $local = false;
        for ($i = 0; $i < count($subtype_split); $i++) {

            $value = $subtype_split[$i];
            //removing spaces
            $strfind = ltrim($value);
            $strfind = rtrim($strfind);
            //contains?
            $local = strpos($row["erromessage"], $strfind);


            if ($local !== false) {
                //removing string match to not mistake next find
                $newstr = substr($row["erromessage"], 0, $local);
                $newstr .= substr($row["erromessage"], $local + strlen($strfind), strlen($row["erromessage"]) - $local);
                $row["erromessage"] = $newstr;

                //if is the last interation and local is true, find
                if ($i == count($subtype_split) - 1) {
                    $find = true;
                }

            } else {
                $i = count($subtype_split);
            }
        }

        //find all elements in message?
        if ($find)
            break;

        //replace typeerro to next check
        $row["erromessage"] = $typeOriginal;


    }


    //$local = editDistDP($row["subtype"], $typeError[2], strlen($row["subtype"]), strlen($typeError[2]));
    if($local !== false){

        $query2 = "UPDATE compilation SET enhancedmessagefound = '".$row2["id"]."' WHERE id = ".$row["id"];
        $result3 = $mysqli->query($query2);
        echo $query2;
    }else{
        echo 0;
    }


}
