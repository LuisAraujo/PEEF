<?php
@include "conection_database.php";
@include "manager_section.php";

$idcode = $_POST["idcode"];
setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT name, code FROM Code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

/*creating a tem file for execute code*/
$temp = tmpfile();
fwrite($temp, $row["code"]);
fseek($temp, 0);

//$cmd = 'python '.$namefile.'.py 2>&1';
$cmd = 'python '. stream_get_meta_data($temp)['uri'] .' 2>&1';

$out = "";
$error = "";

exec($cmd, $out, $error);

if($error == 0){
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

@include "save_compilation.php";

?>