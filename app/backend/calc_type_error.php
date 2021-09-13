<?php
//todo: aparentemente n é usado. Aparentemente duplicando em identify_errotype

echo "<title>Extract Erro Type Line and Msg</title>";
@include "conection_database.php";

$errostr = "SystemExit,KeyboardInterrupt,GeneratorExit,Exception,StopIteration,StandardError,BufferError,ArithmeticError,FloatingPointError,OverflowError,ZeroDivisionError,AssertionError,AttributeError,EnvironmentError,IOError,OSError,WindowsError (Windows),VMSError (VMS),EOFError,ImportError,LookupError,IndexError,KeyError,MemoryError,NameError,UnboundLocalError,ReferenceError,RuntimeError,NotImplementedError,SyntaxError,IndentationError,TabError,SystemError,TypeError,ValueError,UnicodeError,UnicodeDecodeError,UnicodeEncodeError,UnicodeTranslateError,Warning,DeprecationWarning,PendingDeprecationWarning,RuntimeWarning,SyntaxWarning,UserWarning,FutureWarning,ImportWarning,UnicodeWarning,BytesWarning";
$errorstype = explode(",", $errostr);
$idproject = $_POST["idproject"];

$query = "SELECT id, erromessage FROM compilation WHERE typeError IS NULL AND lineError IS NULL AND Code_id = (SELECT id FROM code WHERE Project_id = $idproject  LIMIT 1)";

//echo $query;

$result = $mysqli->query($query);


while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
   // echo $row["id"]. "  ". $row["erromessage"]."<br>";
    //break;

    if( trim( $row["erromessage"] ) ==  ""){

        $query2 = "UPDATE compilation SET typeError = 'no-error', lineError = '-1' WHERE id = '".$row["id"]."'";
        $result2 = $mysqli->query($query2);
       // echo $query2;
    }

    for($i = 0; $i < count($errorstype); $i++){
        $pos  = strpos($row["erromessage"], $errorstype[$i]);
       if( $pos ){
           echo "<br><b>".$errorstype[$i]. "</b><br>";

           $nline = strpos($row["erromessage"], "line");
           $nline = $nline + strlen("line ");
           $line = "";

           while ( is_numeric( $row["erromessage"][$nline]) ) {
               $line .= $row["erromessage"][$nline++];
           }

           echo "linha: " . $line ."<br>";

           echo "id: ".$row["id"]."<br>";

           $mensagemcomp = substr( $row["erromessage"] , $pos + strlen($errorstype[$i]) + 2, strlen($row["erromessage"]));

           echo "msg: " .  $mensagemcomp. "<br>";

           $query2 = "UPDATE compilation SET typeError = '".$errorstype[$i] . "' , lineError = '" .$line . "' , compMessage = '". $mensagemcomp ."' WHERE id = '".$row["id"]."'";
           $result2 = $mysqli->query($query2);

           //echo $query2;

           break;
       }
    }
}
?>