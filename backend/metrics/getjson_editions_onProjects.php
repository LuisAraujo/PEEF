<?php

@include "conection_database.php";
$idproject = $_POST["idproject"];
$currentRow = 0;

//$query = "SELECT CodeCompilation.id as codeid, LineEdited.id, diff, lineError, code, date, hours, typeError, line FROM Compilation INNER JOIN CodeCompilation ON  Compilation.id = CodeCompilation.Compilation_id INNER JOIN LineEdited ON LineEdited.CodeCompilation_id = CodeCompilation.id  WHERE Code_id = (SELECT Code.id FROM Code WHERE Project_id = ".$idproject." LIMIT 1) ORDER BY codeid";
$query = "SELECT CodeCompilation.id as codeid,  lineError, code, date, hours, typeError FROM Compilation INNER JOIN CodeCompilation ON  Compilation.id = CodeCompilation.Compilation_id WHERE Code_id = (SELECT Code.id FROM Code WHERE Project_id = ".$idproject." LIMIT 1) ORDER BY codeid";
$result = $mysqli->query($query);
$currentRow = 0;
$jsonReturn = '{ "idproject": "'. $idproject.'" , "codes": ['  ;



while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $currentRow++;

    $code = str_replace('"' , "'" , $row['code']);

    //$jsonReturn .='{"id": "'.$row['id'].'",  "date": "'.$row['date'].'",  "hours": "'.$row['hours'].'", "typeError": "'.$row['typeError'].'", "line": [';
    $jsonReturn .='{"date": "'.$row['date'].'",  "hours": "'.$row['hours'].'", "typeError": "'.$row['typeError'].'", "line": [';

    $query2 = "SELECT diff, line FROM LIneEdited WHERE CodeCompilation_id = ".$row['codeid'];
    $result2 = $mysqli->query($query2);

    $currentRow2 = 0;
    $diff = 0;
    while($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
        $currentRow2++;

        $jsonReturn .= '"'.$row2['line'].'"';
        $diff += intval($row2['diff']);

        if($currentRow2 < $result2->num_rows)
            $jsonReturn .= ', ';
    }

    $jsonReturn .='] , "diff": "'.$diff.'", "code": [';

    $arrcode = explode("\n", $code);
    for($i = 0; $i < count($arrcode); $i++) {
        $jsonReturn .= '"'. str_replace('"' , "'" ,$arrcode[$i]) . '"';

        if ($i < count($arrcode) - 1)
            $jsonReturn .= ",";
    }

    $jsonReturn .='] }';


    if($currentRow < $result->num_rows)
        $jsonReturn .= ', ';
}


$jsonReturn .= ']}';

echo $jsonReturn;
?>