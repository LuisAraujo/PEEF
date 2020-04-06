<?php
//EXTRATOR DE ERROS

@include "conectionDataBase.php";

$idcode = $_POST["idcode"]; //"file"; //mudar para parâmetro

$result = $mysqli->query("SELECT code FROM Code Where Code.id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

$temp = tmpfile();
fwrite($temp, $row["code"]);
fseek($temp, 0);

//$cmd = 'python '.$namefile.'.py 2>&1';
$cmd = 'python '. stream_get_meta_data($temp)['uri'] .' 2>&1';

$output = exec($cmd, $out, $error);

if($error == 0){
	print("<span class='alert'> Program Compiled with Sucess! </span> <br><br>");
	
	foreach($out as $o)
		print "<br>> " .$o;
}else{ 
	print("<b>Error founded! <br> </b>");
	foreach($out as $o){
		$outsplited = split(",", $o);
		foreach($outsplited as $os)
			print $os . "<br>";

	}

}

fclose($temp);

?>