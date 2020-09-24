<?php

include "../conection_database.php";
include "../runcode/getnamestemp.php";

$idcode = $_POST["idcode"];
$iduser = $_POST["iduser"];
$token = $_POST["token"];
error_reporting(0);

//name main folder of user
$folderprefix2 = getnamefoldertemp_session($iduser);
//name actual folder with token
$folderprefix = getnamesubfoldertemp_session($iduser, $token);
//name of input file
$ouputname = getnamefileoutputtemp_session($iduser,$token);
//name of input file. num is string for replace to number of input
$inputname = getnamefileinputtemp_session($iduser,$token);
//name of error
$errorname = getnamefileerror( $iduser, $token );

// echo $nametemp;
//if user folder arealdy exists
if( is_dir($folderprefix2) ){
    //delete all files and folders
    $objects = scandir($folderprefix2);
    foreach ($objects as $object) {
        if ($object != "." && $object != "..")
            if (filetype($folderprefix2."/".$object) == "dir") {
                array_map('unlink', glob("$folderprefix2"."/"."$object/*.*"));
                rmdir($folderprefix2."/".$object);
            }
    }
}else{
    //create user folder
    mkdir($folderprefix2);
}

//create actual folder of user with token, if there a error, send _error
if( mkdir($folderprefix) != 1){
    //essa lógica n está correta
    //open output'file
    $myfile = fopen($ouputname, "a") ;
    if ( !$myfile ) {
        throw new Exception('File open failed.');
    }

    fwrite($myfile, "__error\n");
    fclose($myfile);
}


$namefile = getnamefilecode_session( $iduser, $token);

$result = $GLOBALS['mysqli']->query("SELECT name, code FROM Code Where id = $idcode;");

$row = $result->fetch_array(MYSQLI_ASSOC);

$codeCharaterNull = str_replace ('input(','input(chr(0)', $row["code"]);
$codeCharaterNull = str_replace ('input(chr(0)"','input( chr(0) + "<< ', $codeCharaterNull);
$codeCharaterNull = str_replace ('input(chr(0))','input( chr(0) + "<<")', $codeCharaterNull);

$temp = fopen($namefile, "a+");

if(!$temp) {
    echo "0";
}else{
    fwrite($temp, $codeCharaterNull);
    fclose($temp);
    echo  $namefile;
}


?>