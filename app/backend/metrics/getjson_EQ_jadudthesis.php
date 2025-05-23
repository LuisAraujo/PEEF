<?php

@include "../conection_database.php";
@include "calc_stringedit.php";

$idstudent = $_POST["idstudent"];

echo getjsonEQ($idstudent);

function getjsonEQ($idstudent )
{

    $query2 = "SELECT Project.id, Project.Activity_id as idactivity FROM Project INNER JOIN Enrollment ON Enrollment.id = Project.Enrollment_id WHERE Enrollment.Student_id = '$idstudent'";

    $result2 = $GLOBALS['mysqli']->query($query2);

    $array = [];
    $array2 = [];


    //get all projects
    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {

        $currentRow = 0;

        $currentRow++;
        $array2["id"] = $row2['id'];
        $array2["idactivity"] = $row2['idactivity'];

        $array2["scoresections"] = [];

        //get all compilation of project
        $query = "SELECT compilation.id as id, date, hours, erromessage,  codecompilation.id as idcode, codecompilation.code as code, typeError, lineError  FROM compilation LEFT JOIN codecompilation ON compilation.id = codecompilation.Compilation_id WHERE Code_id = (SELECT id FROM code WHERE Project_id = " . $row2['id'] . " LIMIT 1)";
        $result = $GLOBALS['mysqli']->query($query);

        $tempSession = array();
        $arraySession = array();
        $countSession = 0;
        $arraySession[$countSession] = array();


        $row = $result->fetch_array(MYSQLI_ASSOC);

        //old row
        $e1 = $row;
        array_push($tempSession, $row);


        $limiteSession = 60 * 5;

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            //old row
            $starttimestamp = strtotime($e1["date"] . "  " . $e1["hours"]);
            //current row
            $endtimestamp = strtotime($row["date"] . "  " . $row["hours"]);
            //difference time
            $difference = abs($endtimestamp - $starttimestamp);

            //new Session identified
            if ($difference > $limiteSession) {
                if (count($tempSession) >= 7)
                    $arraySession[$countSession] = $tempSession;

                $countSession++;
                $tempSession = array();
            }

            array_push($tempSession, $row);

            //update old row
            $e1 = $row;
        }

        //to last session
        if (count($tempSession) >= 7)
            $arraySession[$countSession] = $tempSession;


        //END DIVIDING SESSION


        $totalScore = array();

        $i = 0;
        //for to sessions
        foreach ($arraySession as $value) {

            $oldvalues = null;
            array_push($totalScore, 0);

            //for to events in sessions
            foreach ($value as $value2) {

                if ($oldvalues == null) {
                    $oldvalues = $value2;
                    continue;
                }

                //if old or currente compilation is not error
                if (($value2["typeError"] == "no-error") ||
                    ($oldvalues["typeError"] == "no-error")) {

                    continue;
                }

                $score = 0;
                $line = $oldvalues;

                if (strcmp(trim($line["erromessage"]), ",") != 0) {
                    //Do both events  ends in error
                    $score += 2;

                    //Same type error?
                    if (strcmp($line["typeError"], $value2["typeError"]) == 0) {
                        $score += 3;
                    }


                    if (strcmp($line["lineError"], $value2["lineError"]) == 0) {
                        $score += 3;
                    }


                    //maybe change this calc for other file and save data in database


                    //get lines editeds in code compilation of before one compilation
                    $query3 = "SELECT count(*) as qtd FROM lineEdited WHERE codeCompilation_id = (SELECT id FROM CodeCompilation WHERE Compilation_id = " . (intval($value2["id"]) - 1) . " LIMIT 1) AND line >= " . (intval($value2["lineError"]) - 3) . " AND line <= " . (intval($value2["lineError"]) + 3);
                    $result3 = $GLOBALS['mysqli']->query($query3);
                    $row3 = $result3->fetch_array(MYSQLI_ASSOC);
                    if (intval($row3["qtd"]) > 0) {
                        $score += 1;
                        // echo ">>>> same edit location <br>";
                    }


                    //Normalize: Divide the score assigned to each pair by 11 (the
                    //maximum value possible for each pair).

                    $totalScore[count($totalScore) - 1] += $score / 11;

                } // end for events in session

                //Sum the scores and divide by the number of pairs
                //This average is taken as the error quotient (EQ) for the session.
                $totalScore[count($totalScore) - 1] = $totalScore[count($totalScore) - 1] / (count($value) - 1);

            }

            $i++;
        }

        //EXIBING JSON
        for ($i = 0; $i < count($totalScore); $i++) {
            $array2["scoresections"][] =  number_format($totalScore[$i], 3, '.', '') ;
        }

        $array[] = $array2;
    }


    return json_encode($array);
}
