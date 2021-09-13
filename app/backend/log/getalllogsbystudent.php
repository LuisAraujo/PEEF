<?php

@include "../conection_database.php";

function getAllLog($idstudent,$idcourse  )
{
    $arr = [];
    $sql = "SELECT date, hours, Action.name as action, id_ref FROM Log INNER JOIN Action ON Log.Action_id = Action.id WHERE  Enrollment_id = (SELECT  id FROM enrollment WHERE Student_id = '$idstudent' AND Course_id = '$idcourse') ORDER BY date ASC, hours ASC";
    $result = $GLOBALS['mysqli']->query($sql);

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $arr[] = [$row["action"], $row["id_ref"], $row["date"], $row["hours"], "-1"];
    }


    $sql2 = "SELECT id FROM Project WHERE Enrollment_id = (SELECT  id FROM enrollment WHERE Student_id = '$idstudent' AND Course_id = '$idcourse')";
    $result2 = $GLOBALS['mysqli']->query($sql2);

    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
        //echo $row2["id"]. "<br>";

        $sql3 = "SELECT  date, hours, typeError, testpassed FROM compilation INNER JOIN codecompilation ON  compilation.id = codecompilation.Compilation_id LEFT JOIN enhancedmessage ON enhancedmessage.id = compilation.enhancedmessagefound WHERE Code_id = (SELECT code.id FROM code WHERE Project_id = " . $row2["id"] . " LIMIT 1) ";
        $result3 = $GLOBALS['mysqli']->query($sql3);

        while ($row3 = $result3->fetch_array(MYSQLI_ASSOC)) {


            if (strcmp($row3["testpassed"], "-1") == 0)
                $arr[] = ["compilation", $row2["id"], $row3["date"], $row3["hours"], $row3["typeError"]];
            else
                $arr[] = ["test", $row2["id"], $row3["date"], $row3["hours"], $row3["testpassed"]];
        }

    }

    function cmp($a, $b)
    {
        $timea = strtotime($a[2] . " " . $a[3]);
        $timeb = strtotime($b[2] . " " . $b[3]);

        if ($timea == $timeb) {
            return 0;
        }
        return ($timea < $timeb) ? -1 : 1;
    }

    usort($arr, "cmp");

    return  $arr;
}