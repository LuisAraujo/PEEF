<?php


include 'getnamestemp.php';

error_reporting(0);
$token = $_POST["token"];
$iduser = $_POST["iduser"];

$folderprefix = getnamesubfoldertemp_session($iduser,$token);
$ouputname = getnamefileoutputtemp_session($iduser,$token);


$myfile = fopen($ouputname, "r");
if ( !$myfile ) {
	echo "error";
	return;
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