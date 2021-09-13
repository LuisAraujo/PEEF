<?php

include "getalllogsbystudent.php";


$idstudent = $_POST["idstudent"];
$idcourse = $_POST["idcourse"];


$arr = getAllLog($idstudent,$idcourse);
//echo json_encode($arr);


$arrproject = [];
$lastid = -1;
$lastaction = '';

for ($i =0; $i < count( $arr); $i++) {
    //var_dump( $arr[$i]);
    //echo "<br>";

    $value = $arr[$i];

    $action = "";

    if ( !strcmp($value[0], "oncourse") || !strcmp($value[0], "outproject") || !strcmp($value[0], "offcourse") || !strcmp($value[0], "offline")) {
        $action = "off";
        if(strcmp($lastaction, $action) == 0 ) {
           continue;
        }
        //limpando dados repetidos em sequencia
        if( strcmp($value[0], "outproject") != 0){
            //se n houver um last id, ou seja, iniciou por um lod de entrad em curso, online e etc..
            if($lastid != -1)
                $value[1] = $lastid;
            else
                continue;
        }

    }else if(!strcmp($value[0], "inproject") ) {
        $action = "on";
        $lastid = $value[1];

        //limpando dados repetidos em sequencia
        if(strcmp($lastaction, $action) == 0 ) {
            continue;
        }


    }else if ( !strcmp($value[0], "compilation") || !strcmp($value[0], "test") || !strcmp($value[0], "fixingcode") || !strcmp($value[0], "indescription") ) {
        $action = $value[0];

    }else{

        continue;
    }


    if( !isset( $arrproject[ $value[1] ]  ) ) {

        $arrproject[$value[1]] = [];
    }
    $lastaction = $action;
    $arrproject[ $value[1] ][] = [ $action, $value[2], $value[3], $value[4]];
}


echo json_encode($arrproject);