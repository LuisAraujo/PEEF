<?php

//Depreciado - This is a recurvise solution O(3^m)
/*
function editDistance($str1, $str2, $m, $n){

   // If first string is empty,
    // the only option is to insert.
    // all characters of second
    // string into first
    if ($m == 0)
        return $n;

    // If second string is empty,
    // the only option is to
    // remove all characters of
    // first string
    if ($n == 0)
        return $m;

    // If last characters of two
    // strings are same, nothing
    // much to do. Ignore last
    // characters and get count
    // for remaining strings.
    if ($str1[$m - 1] == $str2[$n - 1])
    {
        return editDistance($str1, $str2,
            $m - 1, $n - 1);
    }

    // If last characters are not same,
    // consider all three operations on
    // last character of first string,
    // recursively compute minimum cost
    // for all three operations and take
    // minimum of three values.

    return 1 + min(editDistance($str1, $str2,
            $m, $n - 1), // Insert
            editDistance($str1, $str2,
                $m - 1, $n), // Remove
            editDistance($str1, $str2,
                $m - 1, $n - 1)); // Replace
}

//Depreciado
function comparation_lines($code1, $code2 ){
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

        $dif = editDistance($arr1[$i], $arr2[$i], strlen($arr1[$i]), strlen($arr2[$i]));
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

        if( modification_inline($code1, $code2, $lines[$j]) )
            return true;
    }

    return false;
}


function modification_inline($code1, $code2, $line){
    echo "code " . $code1 . "<br>";
    echo "line " . $line . "<br>";

    //split code by lines
    $arr1 = explode("\n", $code1);
    $arr2 = explode("\n", $code2);

    //cause erro line be after last line
    if($line-1 >=  count($arr1))
        return false;


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

    $dif = editDistance($arr1[$line-1], $arr2[$line-1], strlen($arr1[$line-1]), strlen($arr2[$line-1]));

    if($dif != 0){
        echo "same location";
        return true;
    }

    return false;
}


*/

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


?>
