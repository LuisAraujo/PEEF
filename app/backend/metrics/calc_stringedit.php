<?php

/*Calc edit string with dinamic project */
function editDistDP($str1, $str2, $m, $n)
{

    $dp = array( array_fill(0, $m+1, 0),array_fill(0, $n+1, 0));

    // Fill d[][] in bottom up manner
    for ($i = 0; $i <= $m; $i++)
    {
        for ($j = 0; $j <= $n; $j++)
        {

            // If first string is empty,
            // only option is to insert
            // all characters of second string
            if ($i == 0)
                $dp[$i][$j] = $j ; // Min. operations = j

            // If second string is empty,
            // only option is to remove
            // all characters of second string
            else if($j == 0)
                $dp[$i][$j] = $i; // Min. operations = i

            // If last characters are same,
            // ignore last char and recur
            // for remaining string
            else if($str1[$i - 1] == $str2[$j - 1])
                $dp[$i][$j] = $dp[$i - 1][$j - 1];

            // If last character are different,
            // consider all possibilities and
            // find minimum
            else
            {
                $dp[$i][$j] = 1 + min($dp[$i][$j - 1],     // Insert
                        $dp[$i - 1][$j],     // Remove
                        $dp[$i - 1][$j - 1]); // Replace
            }
        }
    }
    return $dp[$m][$n] ;
}

/*Comparations line by line*/
function comparation_linesDP($code1, $code2 ){
    $lines  = array();
    //split code by lines
    $arr1 = explode("\n", $code1);
    $arr2 = explode("\n", $code2);

    //complementing array2
    if(count($arr2) > count($arr1)) {
        for($l = count($arr1); $l < count($arr2); $l++){
            array_push($arr1, "");
        }
    }
    //complementing array2
    if(count($arr1) > count($arr2)) {
        for($l = count($arr2); $l < count($arr1); $l++){
            array_push($arr2, "");
        }
    }

    for($i = 0; $i < count($arr1) ; $i++) {

        $dif = editDistDP($arr1[$i], $arr2[$i], strlen($arr1[$i]), strlen($arr2[$i]));
        if($dif != 0) {
            //line, dif score
            array_push($lines, array( ($i + 1) , $dif) );
        }
    }

    return $lines;
}



function modification_inrange($code1, $code2, $line){
    $lines = array();
    for($i= -3; $i <= 3 ; $i++ ){
        $resline = $line + $i;
        //min limit of line is 1
        if($resline > 0 )
            array_push($lines,$resline );
    }

    for($j = 0; $j < count($lines); $j++ ) {

        if( modification_inlineDP($code1, $code2, $lines[$j]) )
            return true;
    }

    return false;
}


