<?php


include 'getnamestemp.php';
error_reporting(0);
$token = $_POST["token"];
$iduser = $_POST["iduser"];

$folderprefix = getnamesubfoldertemp_session($iduser,$token);
$inputname = getnamefileinputtemp_session($iduser,$token);

$n_input = $_POST["n_input"];
$input = $_POST["input"];

$a = array($n_input);

$localinputnme = str_replace(["num"], $a, $inputname);
$myfile = fopen($localinputnme, "w+");
//write input data in file
fwrite($myfile, $input);
fclose($myfile);

echo 1;

?>