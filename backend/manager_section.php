<?php

session_start();

$_SESSION['currentcode'];
$_SESSION['currentproject'];
$_SESSION['currentuser'];

function setcurrentcode_session($currentcode){
    $_SESSION['currentcode'] = $currentcode;
}

function setcurrentproject_session($currentproject){
    $_SESSION['currentproject'] = $currentproject;
}

function setcurrentuser_session($currentuser){
    $_SESSION['currentuser'] = $currentuser;
}


function getcurrentcode_session(){
    return $_SESSION['currentcode'];
}

function getcurrentproject_session(){
    return $_SESSION['currentproject'];
}

function getcurrentuser_session(){
    return $_SESSION['currentuser'];
}


?>