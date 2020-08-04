<?php
@include "conection_database.php";
@include "manager_section.php";

$idcode = 1; //getcurrentcode_session();

$result = $mysqli->query("SELECT name, code FROM Code Where id = $idcode;");
$myArray = array();

$row = $result->fetch_array(MYSQLI_ASSOC);

/*creating a tem file for execute code*/
$temp = tmpfile();
fwrite($temp, $row["code"]);
fseek($temp, 0);

$query = "SELECT * FROM Test Where Activity_id = (SELECT DISTINCT Activity.id FROM Activity INNER JOIN Project ON Activity.id = Project.Activity_id INNER JOIN Code ON Code.Project_id = Project.id WHERE Code.id =  $idcode)";
$test = $mysqli->query($query);

echo $query;

$row2 = $test->fetch_array(MYSQLI_ASSOC);

//while($row2 != false) {

    $temp_testinput = tmpfile();
    fwrite($temp_testinput, $row2["input"]);
    fseek($temp_testinput, 0);

    //$cmd = 'python '.$namefile.'.py 2>&1';
    $cmd = 'python ' . stream_get_meta_data($temp)['uri'] .  '< '. stream_get_meta_data($temp_testinput)['uri'].'';

    $out = "";
    $error = "";

    exec($cmd, $out, $error);

    if( strcmp( $out[0], $row2["output"])  === 0){
        echo "ok";
    }else{
        echo "erro";
        echo  $out[0]."<br>";
    }

//}
fclose($temp);


?>