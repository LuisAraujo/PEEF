<?php

function remove_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
        chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
        chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
        chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
        chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
        chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
        chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
        chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
        chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
        chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
        chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
        chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
        chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
        chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
        chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
        chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
        chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
        chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
        chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
        chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
        chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
        chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
        chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
        chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
        chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
        chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
        chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
        chr(195).chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
        chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
        chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
        chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
        chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
        chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
        chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
        chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
        chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
        chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
        chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
        chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
        chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
        chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
        chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
        chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
        chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
        chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
        chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
        chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
        chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
        chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
        chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
        chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
        chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
        chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
        chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
        chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
        chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
        chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
        chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
        chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
        chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
        chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
        chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
        chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
        chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
        chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
        chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
        chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
        chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
        chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
        chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
        chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
        chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
        chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
        chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
        chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
        chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
        chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
        chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
        chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
        chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
        chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
        chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
        chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
        chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
        chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
        chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
        chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
        chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
        chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
        chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
        chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
        chr(197).chr(190) => '/', chr(197).chr(191) => '//'
    );

    $string = strtr($string, $chars);

    return $string;
}


//USED ON EDIT LINE VIEW

@include "../conection_database.php";
$idproject = $_POST["idproject"];
$currentRow = 0;

//$query = "SELECT CodeCompilation.id as codeid, LineEdited.id, diff, lineError, code, date, hours, typeError, line FROM Compilation INNER JOIN CodeCompilation ON  Compilation.id = CodeCompilation.Compilation_id INNER JOIN LineEdited ON LineEdited.CodeCompilation_id = CodeCompilation.id  WHERE Code_id = (SELECT Code.id FROM Code WHERE Project_id = ".$idproject." LIMIT 1) ORDER BY codeid";
$query = "SELECT compilation.id as compid, codecompilation.id as codeid,  lineError, code, date, hours, typeError, enhancedmessage, testpassed, compMessage FROM compilation INNER JOIN codecompilation ON  compilation.id = codecompilation.Compilation_id LEFT JOIN enhancedmessage ON enhancedmessage.id = compilation.enhancedmessagefound WHERE Code_id = (SELECT code.id FROM code WHERE Project_id = ".$idproject." LIMIT 1) ORDER BY codeid";
$result = $mysqli->query($query);


$currentRow = 0;
$jsonReturn = '{"idproject": "'. $idproject.'" , "codes": ['  ;


while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $currentRow++;

    $code = str_replace('"' , "'" , $row['code']);
    $code =  preg_replace( "/\r|\n/", "", $code );
    $code =  str_replace( "\"", "'", $code );
    $code = preg_replace("/(?!^).(?!$)/", "*", $code);
    $code = str_replace("\t",'    ', $code);
    $code = str_replace("{",'#2774', $code);
    $code = str_replace("}",'#2775', $code);
    $code = str_replace("[",'#x5d;', $code);
    $code = str_replace("]",'#x5b;', $code);

    $row['compMessage']  =  preg_replace( "/\r|\n/", "", $row['compMessage'] );
    $row['compMessage']  =  str_replace( "\"", "'", $row['compMessage'] );


    //$jsonReturn .='{"id": "'.$row['id'].'",  "date": "'.$row['date'].'",  "hours": "'.$row['hours'].'", "typeError": "'.$row['typeError'].'", "line": [';
    $jsonReturn .='{"compid": "'.$row['compid'].'","date": "'.$row['date'].'",  "hours": "'.$row['hours'].'", "typeError": "'.$row['typeError'].'", "EnhancedMessage": "'.$row['enhancedmessage'].'", "compMessage": "'.$row['compMessage'].'","TestPassed": "'.$row['testpassed'].'","line": [';

    $query2 = "SELECT diff, line FROM lineedited WHERE CodeCompilation_id = ".$row['codeid'];
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

        $arrcode[$i] = str_replace(";", "", $arrcode[$i]);

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