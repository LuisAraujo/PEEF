<?php

function getnamefoldertemp_session($iduser){
   // if(gettypeuser() == "leaner" ) {
        $hex_iduser = md5( $iduser );
        return "../userdatarunnig/tempuser_" . $hex_iduser . "/";
   // }
}

function getnamesubfoldertemp_session($iduser, $token){
    return getnamefoldertemp_session($iduser) . $token;
}

function getnamefileoutputtemp_session($iduser, $token){
    return getnamesubfoldertemp_session($iduser, $token)."/output.txt";
}


function getnamefileinputtemp_session($iduser, $token){
    return getnamesubfoldertemp_session($iduser, $token)."/input_num.txt";
}


function getnamefileerror($iduser, $token){
    return getnamesubfoldertemp_session($iduser, $token)."/error.log";
}

function getnamefileerror2($iduser, $token){
    return getnamesubfoldertemp_session($iduser, $token)."/error_unitytest.log";
}


function getnamefilecode_session($iduser, $token){
    return getnamesubfoldertemp_session($iduser, $token)."/filecode.py";
}

?>