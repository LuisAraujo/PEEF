<?php
@include "conection_database.php";
@include "manager_section.php";
@include "unitytest/getnamestemptest.php";

$idcode = $_POST["idcode"];
$iduser = getcurrentuser_session();
setcurrentcode_session($idcode);

$result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

$codeCharaterNull = str_replace ('input(','input(chr(0)', $row["code"]);
$codeCharaterNull = str_replace ('input(chr(0)"','input( chr(0) + "<< ', $codeCharaterNull);
$codeCharaterNull = str_replace ('input(chr(0))','input( chr(0) + "<<")', $codeCharaterNull);

/*creating a tem file for execute code*/
$temp = tmpfile();
fwrite($temp, $codeCharaterNull);
fseek($temp, 0);


//$temp_log = tmpfile();
//fseek($temp_log, 0);


/*TEST FILE*/
$query = "SELECT * FROM Test Where Activity_id = (SELECT DISTINCT Activity.id FROM Activity INNER JOIN Project ON Activity.id = Project.Activity_id INNER JOIN Code ON Code.Project_id = Project.id WHERE Code.id =  $idcode)";
//echo $query;

$test = $mysqli->query($query);
$row2 = $test->fetch_array(MYSQLI_ASSOC);

$name_testinput = "input.txt";
$name_testoutput ="output.text";
$name_testerror ="error.log";

//create file input here

$cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. $name_testinput.' 2>&1';


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


        $temp_testinput = fopen($name_testinput, "w");
        fwrite($temp_testinput, $row2["input"]);
        fclose($temp_testinput);

        $temp_testoutput =  fopen($name_testoutput, "w");
        $temp_testerror =  fopen($name_testerror, "w");

        /** EXECUTING CODE ***/
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("file", $name_testerror, "a")
        );

        //$cmd = 'python '.$namefile.'.py 2>&1';
        //$cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';
        $process = proc_open('py.exe '.  stream_get_meta_data($temp)['uri'], $descriptorspec, $pipes, null, null);
        $flag = "out";
        $temp_testinput = fopen($name_testinput, "r");

        while( (!feof($pipes[1])) ) {

            //for outputs
            if ($flag == "out") {

                //call output function
                $out = fread($pipes[1], 4096) ;

                if( !empty($out)){
                    //open file in a mode
                    $myfile = fopen($name_testoutput, "a");

                    $string_sout = split("\n", $out);

                    for($i=0; $i< count($string_sout); $i++){
                        $local_str =trim(preg_replace('/\s\s+/', ' ', $string_sout[$i] ));
                        $local_str.="" ;

                        //to php when out is 0 is like empty - https://stackoverflow.com/questions/25100890/in-php-why-empty0-returns-true
                        if(strlen($local_str)==0) {
                            continue;
                        }

                        if ($string_sout[$i][0] != chr(0)) {
                            //fwrite($myfile, date("H:i:s")." |". $local_str . "\n");

                            fwrite($myfile, $string_sout[$i] . "\n");
                        }
                    }

                    fclose($myfile);
                }


                //spliting lines
                $louts = split("\n", $out);

                //character hide is the signal to invert to input mode
                if (!empty($louts[count($louts) - 1]))
                    if ($louts[count($louts) - 1][0] == chr(0)) {
                        $flag = "in";
                        //echo $louts[count($louts)-1]."<br>";
                        //return;

                    }



                //for input
            } else {
                $in = fgets($temp_testinput);
                $instring = str_replace( "\n", "|",$in);
                $instring = preg_replace('/\s+/', '', $in);

               // $r = fwrite($pipes[0], $in."\n");
                $r = fwrite($pipes[0], $instring."\n");

                $flag = "out";

            }

        }

        fclose($temp_testinput);
        fclose($temp_testoutput);
        //fclose($temp_testerror);

        $temp_testoutput =  fopen($name_testoutput, "r");

        $out = "";
        $error = "";

        if($count>0)
            $jsontest .= ",";

        $out = fgets($temp_testoutput);
        fclose($temp_testoutput);
        $outstring = str_replace( "\n", "|", $out);
        $outstring = preg_replace('/\s+/', '', $out);

        if (strcmp( $outstring , $row2["output"]) !== 0) {
            $jsontest .= '{"passed":"0" ,';
            $n_error++;
        }else{
            $jsontest .= '{"passed":"1" ,';
        }

        $instring = str_replace( "\n", "|", $row2["input"]);
        $instring = preg_replace('/\s+/', '', $instring);

        $jsontest .= ' "in": "'.$instring.'", "out": "'. $outstring .'", "wait": "'.$row2["output"].'"}';


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

@include "save_compilation.php";

?>