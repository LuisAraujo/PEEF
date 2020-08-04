<?php
@include "conection_database.php";
@include "manager_section.php";

$idcode = 1;//$_POST["idcode"];
setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT name, code FROM Code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

/*creating a tem file for execute code*/
$temp = tmpfile();
fwrite($temp, $row["code"]);
fseek($temp, 0);

/*TEST FILE*/
$query = "SELECT * FROM Test Where Activity_id = (SELECT DISTINCT Activity.id FROM Activity INNER JOIN Project ON Activity.id = Project.Activity_id INNER JOIN Code ON Code.Project_id = Project.id WHERE Code.id =  $idcode)";
//echo $query;

$test = $mysqli->query($query);
$row2 = $test->fetch_array(MYSQLI_ASSOC);
$temp_testinput = tmpfile();
fwrite($temp_testinput, $row2["input"]);
fseek($temp_testinput, 0);

//$cmd = 'python '.$namefile.'.py 2>&1';
$cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';

$out = "";
$error = "";

exec($cmd, $out, $error);

if($error == 0){
	//foreach($out as $o)
	//	print "<br>> " .$o;
    $n_error = 0;
    $count_error = $test->num_rows;

    while($row2) {
        //overwrite file with new test
        fwrite($temp_testinput, $row2["input"]);
        fseek($temp_testinput, 0);

        //$cmd = 'python '.$namefile.'.py 2>&1';
        $cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';

        $out = "";
        $error = "";

        exec($cmd, $out, $error);

        if (strcmp($out[0], $row2["output"]) !== 0) {
            $n_error++;

        }

        $row2 = $test->fetch_array(MYSQLI_ASSOC);
    }

    if($n_error == 0){
        echo 1;
    }else{
        echo  (100*$n_error)/ $count_error;
    }


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