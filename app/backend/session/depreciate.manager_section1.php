<?php

$_SESSION['currentcourse'] = "1";
$_SESSION['currentcode'] = "1";
$_SESSION['currentproject'] = "1";
$_SESSION['currentuser'] = "1";
$_SESSION['typeuser'] = "1";

//set data via post

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
    setcurrentcode_session( $_POST['typeuser']);
    echo $_POST['typeuser'];
}


/** Function to set/get data */
function setcurrentcourse_session($currentcourse){
    $_SESSION['currentcourse'] = $currentcourse;
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
