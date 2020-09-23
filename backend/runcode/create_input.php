<?php


$token = $_POST["token"];

$iduser = 1;
$folderprefix = "../../userdatarunnig/tempuser_" . $iduser."/".$token;
$inputname = $folderprefix."/input_".$token."_num.txt";


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