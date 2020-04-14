<?php
echo "<title>Jadud’s Error Quotient</title>";
@include "conection_database.php";

$idactivity = 1;

$query2 = "SELECT id FROM Project WHERE Activity_id = $idactivity";
$result2 = $mysqli->query($query2);
$jsonReturn = '{ "activity" : '.$idactivity.', "projects" : [';
//echo $result2->num_rows . "<br>";;
$currentRow = 0;

//get all projects
while($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $currentRow++;

    $jsonReturn .='{"id" : '.$row2['id'].' , "scoresections": [';

    //get all compilation of project
    $query = "SELECT * FROM Compilation WHERE Code_id = (SELECT id FROM Code WHERE Project_id = ". $row2['id'] ." LIMIT 1)";
    $result = $mysqli->query($query);

    $tempSession = array();
    $arraySession = array();
    $countSession = 0;
    $arraySession[$countSession] = array();

    if($result->num_rows ==0 ){
        $jsonReturn .= "]}";
        continue;
    }
    $row = $result->fetch_array(MYSQLI_ASSOC);


    //$arraySession[$countSession] = $row;
    $e1 = $row;
    array_push($tempSession, $row);
    //array_push($arraySession[$countSession], $row);
    $limiteSession = 60 * 5;

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $starttimestamp = strtotime($e1["date"] . "  " . $e1["hours"]);
        $endtimestamp = strtotime($row["date"] . "  " . $row["hours"]);
        $difference = abs($endtimestamp - $starttimestamp);

        //new Session identified
        if ($difference > $limiteSession) {
            if (count($tempSession) >= 0)
                $arraySession[$countSession] = $tempSession;

            $countSession++;
            $tempSession = array();
        }
        array_push($tempSession, $row);

        $e1 = $row;
    }

    //last session
    if (count($tempSession) >= 0)
        $arraySession[$countSession] = $tempSession;

    $totalScore = array();

    //for to sessions
    for ($i = 0; $i < count($arraySession); $i++) {

        //for to events in sessions
        for ($j = 1; $j <= count($arraySession[$i]); $j++) {
            $score = 0;
            $line = $arraySession[$i][$j - 1];

            //echo $line["erromessage"]. "<br>";
            if (strcmp(trim($line["erromessage"]), ",") != 0) {
                //Calculate: Score each pair according to the algorithm presented in Figure 4
                $score += 8;


                if ($j < count($arraySession[$i])) {
                    //Collate: Create consecutive pairs from the events in the session, eg. (e1 , e2), (e2 , e3), (e3 , e4), up to (en−1 , en).
                    $l1 = explode(":", explode(",", $line["erromessage"])[1])[0];
                    $l2 = explode(":", explode(",", $arraySession[$i][$j]["erromessage"])[1])[0];


                    if (strcmp($l1, $l2) == 0) {
                        //Calculate: Score each pair according to the algorithm presented in Figure 4
                        $score += 3;
                    }
                }

                //Normalize: Divide the score assigned to each pair by 11 (the
                //maximum value possible for each pair).
                if (!array_key_exists($i, $totalScore))
                    $totalScore[$i] = 0;

                $totalScore[$i] += $score / 11;
            }
        } // end for events in session

        //Sum the scores and divide by the number of pairs
        //This average is taken as the error quotient (EQ) for the session.
        if (!array_key_exists($i, $totalScore))
            $totalScore[$i] = 0;

        $totalScore[$i] = $totalScore[$i] / (count($arraySession[$i]) - 1);


        //precisa dividir cada score par por 11
        //depois soma todos os scores e divide pela quantidade de pares;
    }


    for ($i = 0; $i < count($totalScore); $i++) {
        $jsonReturn .= '"'. number_format($totalScore[$i], 3, '.', '').'"';
        if($i < count($totalScore)-1)
            $jsonReturn .= ',';

    }
    $jsonReturn.= '] }'; //closing sessions and projects


    if($currentRow < $result2->num_rows)
        $jsonReturn .= ', ';
}
$jsonReturn .= ']';
$jsonReturn .= '}';

echo $jsonReturn;
?>