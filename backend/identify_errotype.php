<?php

function checkErroType($erromessage){
    $errorstype = ["SystemExit","KeyboardInterrupt","GeneratorExit","Exception","StopIteration","StandardError","BufferError","ArithmeticError","FloatingPointError","OverflowError","ZeroDivisionError","AssertionError","AttributeError","EnvironmentError","IOError","OSError","WindowsError (Windows),VMSError (VMS),EOFError","ImportError","LookupError","IndexError","KeyError","MemoryError","NameError","UnboundLocalError","ReferenceError","RuntimeError","NotImplementedError","SyntaxError","IndentationError","TabError","SystemError","TypeError","ValueError","UnicodeError","UnicodeDecodeError","UnicodeEncodeError","UnicodeTranslateError","Warning","DeprecationWarning","PendingDeprecationWarning","RuntimeWarning","SyntaxWarning","UserWarning","FutureWarning","ImportWarning","UnicodeWarning","BytesWarning"];


    if( trim( $erromessage ) ==  ""){

        return array("no-error","-1","");

    }

    for($i = 0; $i < count($errorstype); $i++){
        $pos  = strpos($erromessage, $errorstype[$i]);
        if( $pos ){

            $nline = strpos($erromessage, "line");
            $nline = $nline + strlen("line ");
            $line = "";

            while ( is_numeric( $erromessage[$nline]) ) {
                $line .= $erromessage[$nline++];
            }

            $mensagemcomp = substr( $erromessage , $pos + strlen($errorstype[$i]) + 2, strlen($erromessage));
            return array($errorstype[$i], $line, $mensagemcomp);


            break;
        }


    }

}

?>