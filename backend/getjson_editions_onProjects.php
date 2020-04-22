<?php

@include "conection_database.php";
$idproject = 1;
$currentRow = 0;

$query = "SELECT CodeCompilation.id as codeid, LineEdited.id, diff, lineError, code, date, hours, typeError, line FROM Compilation INNER JOIN CodeCompilation ON  Compilation.id = CodeCompilation.Compilation_id INNER JOIN LineEdited ON LineEdited.CodeCompilation_id = CodeCompilation.id  WHERE Code_id = (SELECT Code.id FROM Code WHERE Project_id = ".$idproject." LIMIT 1) ORDER BY codeid";
$result = $mysqli->query($query);
$currentRow = 0;
$jsonReturn = '{ "idproject": "'. $idproject.'" , "codes": ['  ;


while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $currentRow++;

    $code = str_replace('"' , "'" , $row['code']);

    $jsonReturn .='{"id": "'.$row['id'].'", "diff": "'.$row['diff'].'" , "date": "'.$row['date'].'",  "hours": "'.$row['hours'].'", "typeError": "'.$row['typeError'].'", "line": "'.$row['line'].'"';

    $jsonReturn .=', "code": [';

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