<?php
echo "<title>Jadud’s Error Quotient (PROCESSING ERROR)</title>";
@include "conection_database.php";

$errostr = "SystemExit,KeyboardInterrupt,GeneratorExit,Exception,StopIteration,StandardError,BufferError,ArithmeticError,FloatingPointError,OverflowError,ZeroDivisionError,AssertionError,AttributeError,EnvironmentError,IOError,OSError,WindowsError (Windows),VMSError (VMS),EOFError,ImportError,LookupError,IndexError,KeyError,MemoryError,NameError,UnboundLocalError,ReferenceError,RuntimeError,NotImplementedError,SyntaxError,IndentationError,TabError,SystemError,TypeError,ValueError,UnicodeError,UnicodeDecodeError,UnicodeEncodeError,UnicodeTranslateError,Warning,DeprecationWarning,PendingDeprecationWarning,RuntimeWarning,SyntaxWarning,UserWarning,FutureWarning,ImportWarning,UnicodeWarning,BytesWarning";
$errorstype = explode(",", $errostr);

$query = "SELECT id, erromessage FROM Compilation WHERE typeError IS NULL AND lineError IS NULL AND Code_id = (SELECT id FROM Code WHERE Project_id = 1  LIMIT 1)";


$result = $mysqli->query($query);


while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
   // echo $row["id"]. "  ". $row["erromessage"]."<br>";
    //break;

    if( trim( $row["erromessage"] ) ==  ","){

        $query2 = "UPDATE Compilation SET typeError = 'no-error', lineError = '-1' WHERE id = '".$row["id"]."'";
        $result2 = $mysqli->query($query2);
        echo $query2;
    }

    for($i = 0; $i < count($errorstype); $i++){

       if( strpos($row["erromessage"], $errorstype[$i])){
           echo "<br><b>".$errorstype[$i]. "</b><br>";

           $nline = strpos($row["erromessage"], "line");
           $nline = $nline + strlen("line ");
           $line = "";

           while ( is_numeric( $row["erromessage"][$nline]) ) {
               $line .= $row["erromessage"][$nline++];
           }

           echo "linha: " . $line ."<br>";

           echo "id ".$row["id"]."<br>";

           $query2 = "UPDATE Compilation SET typeError = '".$errorstype[$i] . "' , lineError = '" .$line . "' WHERE id = '".$row["id"]."'";
           $result2 = $mysqli->query($query2);

           echo $query2;

           break;
       }
    }
}
?>