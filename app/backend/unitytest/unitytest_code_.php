<?php
header('Content-type: text/html; charset=utf-8');

/*
 * Unity Test
 * Module of execute pass inputs and test outputs with wait outputs
*/

@include "../conection_database.php";
@include "../session/manager_section.php";
@include "../util/getnamestemp.php";
@include  "../identify_errotype.php";

//id code
$idcode = $_POST["idcode"];
//token of this execution
$token = $_POST["token"];
//id user
$iduser = getcurrentuser_session();
//set id code to this session
setcurrentcode_session($idcode);

//get data code
$result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
$myArray = array();
$row = $result->fetch_array(MYSQLI_ASSOC);

//any replace to solve problems of diferences btw output and input
$codeCharaterNull = str_replace ('input(','input(chr(0)', $row["code"]);
$codeCharaterNull = str_replace ('input(chr(0)"','input( chr(0) + "<< ', $codeCharaterNull);
$codeCharaterNull = str_replace ('input(chr(0))','input( chr(0) + "<<")', $codeCharaterNull);

/*creating a temp file for execute code*/
$temp = tmpfile();
fwrite($temp, $codeCharaterNull);
fseek($temp, 0);

/*Get test data*/
$query = "SELECT * FROM test Where Activity_id = (SELECT DISTINCT activity.id FROM activity INNER JOIN project ON activity.id = project.Activity_id INNER JOIN code ON code.Project_id = project.id WHERE code.id =  $idcode)";
$test = $mysqli->query($query);
//out and in waited
$row2 = $test->fetch_array(MYSQLI_ASSOC);

$name_testinput = getnamefileinputtemp_session($iduser, $token);//"input.txt";
$name_testoutput =getnamefileoutputtemp_session($iduser, $token); //"output.text";
$name_testerror = getnamefileerror($iduser, $token); //"error.log";

$temp_testinput = fopen($name_testinput, "w");
//write test data in file
fwrite($temp_testinput, $row2["input"]);
fclose($temp_testinput);

//create file input here (ESTE COMANDO ESTÁ CAUSANDO ERRO!!
$cmd = 'py ' . stream_get_meta_data($temp)['uri'] .  ' < '. $name_testinput.' 2>&1';

$out = "";
$error = "";
$jsontest = "";

$limitTest = 2;

exec($cmd, $out, $error);

//whitout error
if(1){
//if($error){

    $n_error = 0;
    $count_error = $test->num_rows;
    $jsontest = '{"tests": [';
    $count = 0;
    while($row2) {
        //open file of test inputs
        $temp_testinput = fopen($name_testinput, "w");
        //write inputs from database
        fwrite($temp_testinput, $row2["input"]);
        fclose($temp_testinput);

        //open/create file of test outputs
        $temp_testoutput =  fopen($name_testoutput, "w");
        //open/create file of test error
        $temp_testerror =  fopen($name_testerror, "w");

        /** EXECUTING CODE ***/
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("file", $name_testerror, "a") //send error to file
        );

        //$cmd = 'python '.$namefile.'.py 2>&1';
        //$cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';
        //window
        /*Open py.exe and sent data of code ($temp), description and pipes */
        $process = proc_open('py.exe '.  stream_get_meta_data($temp)['uri'], $descriptorspec, $pipes, null, null);

        //flag start is out
        $flag = "out";
        //reading tests
        $temp_testinput = fopen($name_testinput, "r");

        //while has pipe in executing
        while( (!feof($pipes[1])) ) {
            //in this loop we change btw out and in flags
            //for outputs
            if ($flag == "out") {

                //read pipe
                $out = fread($pipes[1], 4096) ;

                //if have not contents
                if( !empty($out)){

                    //open file in a mode append
                    $myfile = fopen($name_testoutput, "a");

                    //get and slipt out of pipe
                    $string_sout = split("\n", $out);

                    //for any line
                    for($i=0; $i< count($string_sout); $i++){
                        //remove chacaters
                        $local_str =trim(preg_replace('/\s\s+/', ' ', $string_sout[$i] ));
                        $local_str.="" ;

                        //to php when out is 0 is like empty - https://stackoverflow.com/questions/25100890/in-php-why-empty0-returns-true
                        if(strlen($local_str)==0) {
                            continue;
                        }

                        //the first character is chr(0)?
                        if ($string_sout[$i][0] != chr(0)) {
                            //write in file output as output
                            fwrite($myfile, $string_sout[$i] );
                        }
                    }

                    fclose($myfile);
                }

                //not is empty
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
                //saving space
                $instring = str_replace(' ', '_', $in);
                //removing any character
                $instring = preg_replace('/\s+/', '', $instring);
                //replace space
                $instring = str_replace('_', ' ', $instring);

                //pass data to input in executing
                $r = fwrite($pipes[0], $instring."\n");
                $flag = "out";

            }
        }
        //END Executing

        fclose($temp_testinput);
        fclose($temp_testoutput);

        $temp_testoutput =  fopen($name_testoutput, "r");
        //$temp_testoutput =  utf8_fopen_read($name_testoutput, "r");

        $out = "";
        $error = "";

        if(($count>0) && ($count < $limitTest))
            $jsontest .= ",";

        //get data from file
        $out = fgets($temp_testoutput);
        fclose($temp_testoutput);

        //remove any character
        $outstring = str_replace( "\n", "|", $out);
        $outstring = preg_replace('/\s+/', ' ', $out);
        //remove left and right spaces
        $outstring = ltrim($outstring);
        $outstring = rtrim($outstring);

        //convert if enconding is not utf8
        if( strcmp( mb_detect_encoding($outstring , ['ASCII', 'UTF-8', 'ISO-8859-1'], false) , "UTF-8") != 0 )
            $outstring = utf8_encode($outstring);



        //comparing out with wait out
        if (strcmp( $outstring , $row2["output"]) !== 0) {
            if(($count < $limitTest))
                $jsontest .= '{"passed":"0" ,';
            $n_error++;
        }else{
            if(($count < $limitTest))
                $jsontest .= '{"passed":"1" ,';
        }

        $instring = str_replace( "\n", "|", $row2["input"]);
        $instring = preg_replace('/\s+/', '', $instring);

        if(($count < $limitTest))
            $jsontest .= ' "in": "'.$instring.'", "out": "'. $outstring .'", "wait": "'.$row2["output"].'"}';


        $row2 = $test->fetch_array(MYSQLI_ASSOC);
        $count++;
    }

    $jsontest .= "], ";

    if($n_error == 0){
        $jsontest .= '"total": {"percent" : "100", "nfail": "0", "npassed": "'.$count_error.'" }';
    }else{
        $percent = (100 - ((100*$n_error)/ $count_error));
        $percent = number_format($percent, 2, '.', '');
        $jsontest .= '"total": {"percent" : "'.$percent. '", "nfail": "'.$n_error.'", "npassed": "'.($count_error-$n_error).'" }';
    }

    $jsontest .= "}";
    echo $jsontest;

    $typeerror = "no-error";
    $lineerror = "-1";

}else{

    $temp_error = fopen($name_testerror, "w");
    //fwrite($temp_error, implode(",", $out) );
    fwrite($temp_error,"teste" );
    fclose($temp_error);
    var_dump($out);

}

fclose($temp);

@include "../save_compilation_unitytest.php";

function utf8_fopen_read($fileName) {
    $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName));
    $handle=fopen("php://memory", "rw");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return $handle;
}