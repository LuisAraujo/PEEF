<?php

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


function compLines( $code1, $code2 ){

    $arr1 = explode(PHP_EOL, $code1);

    $arr2 = explode(PHP_EOL, $code2);

    $lines = array();

    for($i = 0; $i < max ( count($arr1), count($arr2)) ; $i++) {
        if (!array_key_exists($i, $arr1))
            $arr1[$i] = "";

        if (!array_key_exists($i, $arr2))
            $arr2[$i] = "";

        $dif = editDistance($arr1[$i], $arr2[$i], strlen($arr1[$i]), strlen($arr2[$i]));
        if($dif != 0) {
                                    //line, dif score
            array_push($lines, array($i, $dif));
        }

    }

    return $lines;
}



function modInLine( $code1, $code2, $line){

    $arr1 = explode(PHP_EOL, $code1);

    $arr2 = explode(PHP_EOL, $code2);


    //for($i = 0; $i < max ( count($arr1), count($arr2) ) ; $i++) {
        /*if (!array_key_exists($i, $arr1))
            $arr1[$i] = "";

        if (!array_key_exists($i, $arr2))
            $arr2[$i] = "";*/

        $dif = editDistance($arr1[$line-1], $arr2[$line-1], strlen($arr1[$line-1]), strlen($arr2[$line-1]));
        if($dif != 0){
            return true;
        }
    //}

    return false;
}


?>
