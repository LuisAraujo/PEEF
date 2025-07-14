<?php
    header('Content-type: text/html; charset=utf-8');

    @include "../session/manager_section.php";
    @include "../conection_database.php";

    $iduser = getcurrentuser_session();
    $idcode = getcurrentcode_session();

    $erromessage = $_POST["errormsg"];
    $erromessage = str_replace("'" , "\'" , $erromessage);
    $typeerror = [" "," "];
    $lineerror = -1;
    if( strlen( $erromessage) != 0 ){
        //split in two part
        $typeerror = explode( ":", $erromessage);
        $lineerror = explode( "on line", $erromessage);
        if( count($lineerror) != 0){
            //gettin secound part (number)
            $lineerror = $lineerror[1];
        }
        $testpassed = -1;
    }else
        $testpassed = 0;

/* INSERT DATA EXECUTATION IN DATABASE */
   

    //Insert Compilation
    $query = "INSERT compilation (id, date, hours, errormessage, Code_id, typeError, lineError, compMessage) VALUES (NULL, CURDATE() , CURTIME(), '$erromessage',  $idcode, '".$typeerror[0]."', '".$lineerror."', '".$typeerror[1]."')";
    
    $result = $mysqli->query($query);
  
    //save id complitaion inserted
    $idinsered = $mysqli->insert_id;

    //select name and code of this executed code
    $result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
    $row = $result->fetch_array(MYSQLI_ASSOC);
  
    //replace code
    $code2 = str_replace("'" , "\'" , $row['code']);

    //Copying to Code in Compilations
    $query2 = "INSERT CodeCompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $idinsered )";
    //echo $query2;
    $result2 = $mysqli->query($query2);

    echo '{"status": "ok", "id": "'.$idinsered.'"}';

?>