<?php
error_reporting(0);
$token = $_POST["token"];

$iduser = 1;
$folderprefix = "../../userdatarunnig/tempuser_" . $iduser."/".$token;
$ouputname = $folderprefix."/output_".$token.".txt";


$myfile = fopen($ouputname, "r");
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