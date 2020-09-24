<?php

include 'getnamestemp.php';

error_reporting(0);
$token = $_POST["token"];
$iduser = $_POST["iduser"];

$folderprefix = getnamesubfoldertemp_session($iduser,$token);
$errorname = getnamefileerror($iduser, $token );


$myfile = fopen($errorname, "r");
if ( !$myfile ) {
	echo "error";
} 
$lines = "";
if($myfile){
	
	while (($line = fgets($myfile)) !== false) {
		//reading all line in input file
		$lines .= $line;
	}

	fclose($myfile);
	
}

echo  $lines;

?>