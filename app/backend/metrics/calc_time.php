<?php
/*Methods on time in platform*/
@require_once "../conection_database.php";

//get sum of intervals inproject
function calcTimeInPlatform( $idcourse, $idstudent){

    $sql = "SELECT Log.id, Log.date, Log.hours, Action.name as name FROM Log INNER JOIN Action ON Action.id = Log.Action_id WHERE  Enrollment_id = (SELECT id FROM Enrollment Where Student_id = '" . $idstudent. "' AND Course_id = '". $idcourse ."') ORDER BY date ASC, hours ASC";
    $result = $GLOBALS['mysqli']->query($sql);

    $starttime = "";
    $startdate= "";
    $enddate = "";
    $arrtime = array();

    while($row = $result->fetch_assoc() ){


        if($row["name"] == "inproject") {

            $starttime = $row["hours"];
            $startdate= $row["date"];

        }else if($row["name"] == "outproject"){

            $endttime = $row["hours"];
            $enddate= $row["date"];

            if($starttime!= ""){
                $s = new DateTime( $startdate." ".$starttime);
                $e = new DateTime($endttime." ".$enddate);

                $interval = $s->diff($e);
                //var_dump( $interval)."<br>";
                //echo $interval."<br>";
                $arrtime[] = $interval;

            }

            $starttime = "";
            $startdate= "";
            $enddate = "";
        }

    }

    $sec = 0;
    $min = 0;
    $hor = 0;

    for($i=0; $i < count($arrtime); $i++){
        $sec+= intval($arrtime[$i]->s);
        $min+=intval($arrtime[$i]->i);
        $hor+= intval($arrtime[$i]->h);
    }

    $min += intval($sec/60);
    $sec = intval($sec%60);
    $hor += intval($min/60);
    $min= intval($min%60);

    //echo number_format((float)$hor, 0, '.', '').":".number_format((float)$min, 0, '.', '') .":".number_format((float)$sec, 0, '.', '');
    return $hor.":".$min.":".$sec;

}



//get time btw frist access in project and frist sucess test
function calcTimeToSolve( $idcourse, $idstudent, $idproject){
    date_default_timezone_set('America/Sao_Paulo');

    //get frist access to project
    $sql = "SELECT Log.id, Log.date, Log.hours, Action.name as name FROM Log INNER JOIN Action ON Action.id = Log.Action_id WHERE  Enrollment_id = (SELECT id FROM Enrollment Where Student_id = '" . $idstudent. "' AND Course_id = '". $idcourse ."') AND Action.name = 'inproject' AND Log.id_ref = '".$idproject."' ORDER BY date ASC, hours ASC LIMIT 1";
    $result = $GLOBALS['mysqli']->query($sql);

    $row = $result->fetch_assoc();
    $date1 =  $row["date"]." ".$row["hours"]; // "2014-05-15 21:00:00";

    $sql = "SELECT Compilation.id, Compilation.date, Compilation.hours FROM Compilation INNER JOIN Code  ON Code.id = Compilation.Code_id INNER JOIN Project ON Code.Project_id = Project.id WHERE  Project.id = '".$idproject."' AND Enrollment_id = (SELECT id FROM Enrollment Where Student_id = '" . $idstudent. "' AND Course_id = '". $idcourse ."') AND  Compilation.testpassed = 1 ORDER BY date ASC, hours ASC LIMIT 1";
    $result = $GLOBALS['mysqli']->query($sql);

    if(mysqli_num_rows($result) != 0){
        $row = $result->fetch_assoc();
        $date2 =  $row["date"]." ".$row["hours"];
        // "2014-05-15 21:00:00";
    }else{
        $date2 = date("Y-m-d H:i:s");
    }

    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);

    $hour = abs($timestamp2 - $timestamp1 ) / (60*60);

    return sprintf('%02d:%02d', (int) $hour, fmod($hour, 1) * 60 );
}


//get time in platform by day
function calcTimeByDay( $idcourse, $idstudent){
    date_default_timezone_set('America/Sao_Paulo');
    $hour = array();

    $sql = "SELECT Log.id, Log.date, Log.hours, Action.name as name, Log.id_ref FROM Log INNER JOIN Action ON Action.id = Log.Action_id WHERE  Enrollment_id = (SELECT id FROM Enrollment Where Student_id = '" . $idstudent. "' AND Course_id = '". $idcourse ."') AND Action.name = 'inproject' OR  Action.name = 'outproject' ORDER BY date ASC, hours ASC";
    $result = $GLOBALS['mysqli']->query($sql);
    $date1 = NULL;

    while($row = $result->fetch_assoc()){
        if($row["name"]=="inproject") {
            $date1 = $row["date"];
            $hours1 =  $row["hours"];
        }else if($row["name"] == "outproject") {

            $date2 = $row["date"];
            $hours2 =  $row["hours"];

            if(strcmp( $row["date"],  $date1) ==0 ) {

                $timestamp1 = strtotime($date1." ".$hours1);
                $timestamp2 = strtotime($date2." ".$hours2);
                //$h = abs($timestamp2 - $timestamp1) / (60 * 60);
                $array = array();
                $array["time"] = abs($timestamp2 - $timestamp1) / (60 * 60);
                $array["date"] = $date2;

                $array["day"] = date('w', strtotime($date2));

                if( (count($hour)==0)  || strcmp( $hour[count($hour) -1 ]["date"], $date2 ) ) {
                    array_push($hour, $array);
                }else{
                    $hour[count($hour) -1 ]["time"] += $array["time"];
                }
            }
        }
    }

    foreach ($hour as $key => $val){
        $hour[$key]["time"] =  gmdate('H:i:s', floor($hour[$key]["time"] * 3600));
    }

    return json_encode( $hour );
}


//get time btw frist access in project and frist sucess test
function calcTimeByWeekday( $idcourse, $idstudent){
    date_default_timezone_set('America/Sao_Paulo');
    $days = array();
    $days["1"] = "";
    $days["2"] = "";
    $days["3"] = "";
    $days["4"] = "";
    $days["5"] = "";
    $days["6"] = "";
    $days["7"] = "";

    $sql = "SELECT Log.id, Log.date, Log.hours, Action.name as name, Log.id_ref FROM Log INNER JOIN Action ON Action.id = Log.Action_id WHERE  Enrollment_id = (SELECT id FROM Enrollment Where Student_id = '" . $idstudent. "' AND Course_id = '". $idcourse ."') AND Action.name = 'inproject' OR  Action.name = 'outproject' ORDER BY date ASC, hours ASC";
    $result = $GLOBALS['mysqli']->query($sql);
    $date1 = NULL;

    while($row = $result->fetch_assoc()){
        if($row["name"]=="inproject") {
            $date1 = $row["date"];
            $hours1 =  $row["hours"];
        }else if($row["name"] == "outproject") {

            $date2 = $row["date"];
            $hours2 =  $row["hours"];

            if(strcmp( $row["date"],  $date1) ==0 ) {

                $timestamp1 = strtotime($date1." ".$hours1);
                $timestamp2 = strtotime($date2." ".$hours2);

                $time = abs($timestamp2 - $timestamp1) / (60 * 60);
                $dayweek = date('w', strtotime($date2));
                if(isset($days[$dayweek]))
                    $days[$dayweek] +=  $time;
                else
                    $days[$dayweek] =  $time;

            }
        }
    }

    foreach ($days as $key => $val){
        $days[$key] =  gmdate('H:i:s', floor($days[$key] * 3600));
    }


    return json_encode( $days );
}
