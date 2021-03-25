<?php

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if( !isset( $_SESSION['currentcourse']))
    $_SESSION['currentcourse'] = "";

if( !isset( $_SESSION['currentcode']))
    $_SESSION['currentcode'] = "";

if( !isset($_SESSION['currentproject']))
    $_SESSION['currentproject'] = "";

if( !isset($_SESSION['currentuser']))
    $_SESSION['currentuser'] = "";

if( !isset($_SESSION['typeuser']))
    $_SESSION['typeuser'] = "";

//set data via post
if( isset($_POST['free']) ) {
    free_session();
}


if( isset($_POST['currentcourse']) ) {
    setcurrentcourse_session($_POST['currentcourse']);
    echo $_POST['currentcourse'];
}


if( isset($_POST['currentuser']) ) {
    setcurrentuser_session($_POST['currentuser']);
    echo $_POST['currentuser'];
}

if ( isset($_POST['currentproject'])) {
    setcurrentproject_session($_POST['currentproject']);
    echo $_POST['currentproject'];
}

if( isset($_POST['currentcode'])){
    setcurrentcode_session( $_POST['currentcode']);
    echo $_POST['currentcode'];
}


if( isset($_POST['typeuser'])){
    settypeuser($_POST['typeuser']);
    echo $_POST['typeuser'];
}

function setcurrentcourse_session($currentcourse){
    $_SESSION['currentcourse'] = $currentcourse;
}



/** Function to set/get data */
function free_session(){
    session_unset();
}

function setcurrentcode_session($currentcode){
    $_SESSION['currentcode'] = $currentcode;
}

function setcurrentproject_session($currentproject){
    $_SESSION['currentproject'] = $currentproject;
}

function setcurrentuser_session($currentuser){
    $_SESSION['currentuser'] = $currentuser;
}

function settypeuser($typeuser){
    $_SESSION['typeuser'] = $typeuser;
}
//get

function getcurrentcourse_session(){
    return $_SESSION['currentcourse'];
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

function gettypeuser(){
    return $_SESSION['typeuser'];
}


?>