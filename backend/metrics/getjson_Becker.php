<?php
echo "<title>Jadud’s Error Quotient</title>";
@include "conection_database.php";

$idactivity = 1;
$idstudent = 1;

$jsonReturn = "{'activity': : '".$idactivity."', 'students': [";

$query2 = "SELECT Student.id as idstudent, Project.id as idproject FROM Project INNER JOIN Enrollment ON Enrollment_id = Enrollment.id INNER JOIN Student ON Student_id = Student.id WHERE Activity_id =". $idactivity;
$result2 = $mysqli->query($query2);
$currentRow =0;
$lasidstudent = -1;
$arrproject = array();

while($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
    $currentRow =0; $r = 0; $lastErro = ""; $EQ = 0;


    if($lasidstudent != intval($row2['idstudent'])) {

        if($lasidstudent != -1){
            $jsonReturn .= implode(",", $arrproject);
            $jsonReturn .="]' },";
            $arrproject = array();
        }

        $jsonReturn .= " {'id': '" . $row2['idstudent'] . "', 'projects' : '[";


    }

    $query = "SELECT typeError FROM Compilation INNER JOIN Code ON Code_id = Code.id INNER JOIN Project ON Project_id = Project.id INNER JOIN Enrollment ON Enrollment_id = Enrollment.id INNER JOIN Student ON Student_id = Student.id WHERE Student.id = ".$row2['idstudent'];
    $result = $mysqli->query($query);



    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        if ($lastErro == "") {
            $lastErro = $row["typeError"];
            continue;
        }

        if ($lastErro == $row["typeError"]) {
            $r++;
        } else {

            $EQ += ($r * $r) / ($r + 1);
            $r = 0;
        }

        $lastErro = $row["typeError"];

    }

    array_push($arrproject, "{'id': '".$row2['idproject']."', 'score': '".$EQ."'} ") ;
    $lasidstudent = intval($row2['idstudent']);

}

$jsonReturn .="]' }";
$jsonReturn .= "]'}";

echo $jsonReturn;

?>