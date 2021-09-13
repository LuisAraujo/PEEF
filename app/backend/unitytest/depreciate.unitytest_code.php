<?php
@include "conection_database.php";
@include "manager_section.php";
@include "unitytest/getnamestemptest.php";

$idcode = 4;//$_POST["idcode"];
$iduser = getcurrentuser_session();
setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

/*creating a tem file for execute code*/
$temp = tmpfile();
fwrite($temp, $row["code"]);
fseek($temp, 0);


//$temp_log = tmpfile();
//fseek($temp_log, 0);


/*TEST FILE*/
$query = "SELECT * FROM Test Where Activity_id = (SELECT DISTINCT Activity.id FROM Activity INNER JOIN Project ON Activity.id = Project.Activity_id INNER JOIN Code ON Code.Project_id = Project.id WHERE Code.id =  $idcode)";
//echo $query;

$test = $mysqli->query($query);
$row2 = $test->fetch_array(MYSQLI_ASSOC);

$temp_testinput = tmpfile();
fwrite($temp_testinput, $row2["input"]);
fseek($temp_testinput, 0);

//$cmd = 'python '.$namefile.'.py 2>&1';

$cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].' 2>&1';

$out = "";
$error = "";

exec($cmd, $out, $error);

if($error == 0){
	//foreach($out as $o)
	//	print "<br>> " .$o;
    $n_error = 0;
    $count_error = $test->num_rows;
    $jsontest = '{"tests": [';
    $count = 0;
    while($row2) {
        //overwrite file with new test
        fwrite($temp_testinput, $row2["input"]);
        fseek($temp_testinput, 0);

        //$cmd = 'python '.$namefile.'.py 2>&1';
        $cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';

        $out = "";
        $error = "";

        exec($cmd, $out, $error);

        if($count>0)
            $jsontest .= ",";

        if (strcmp($out[ count($out ) -1 ], $row2["output"]) !== 0) {
            $jsontest .= '{"passed":"0" ,';
            $n_error++;
        }else{
            $jsontest .= '{"passed":"1" ,';
        }

        $instring = str_replace( "\n", "|", $row2["input"]);
        $instring = preg_replace('/\s+/', '', $instring);

        $jsontest .= ' "in": "'.$instring.'", "out": "'.$out[ count($out ) -1 ].'", "wait": "'.$row2["output"].'"}';


        $row2 = $test->fetch_array(MYSQLI_ASSOC);
        $count++;
    }

    $jsontest .= "], ";
    if($n_error == 0){
        $jsontest .= '"total": {"percent" : "100", "nfail": "'.$count_error.'", "npassed": "'.$count_error.'" }';
    }else{
        $jsontest .= '"total": {"percent" : "'.(100 - ((100*$n_error)/ $count_error)). '", "nfail": "'.$n_error.'", "npassed": "'.($count_error-$n_error).'" }';
    }

    $jsontest .= "}";
    echo $jsontest;

}else{

	echo "0";

}

fclose($temp);

@include "save_compilation_unitytest.php";

?>