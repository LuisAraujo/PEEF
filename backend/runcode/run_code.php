<?php

    include 'getnamestemp.php';
    @include "manager_section.php";
    @include "../conection_database.php";

    //error_reporting(0);
    //a flag n funciona
    $token = $_POST["token"];
    $iduser = $_POST["iduser"];
    $nametemp = $_POST["nametemp"];
    $idcode = $_POST["idcode"];
    //used to save compilation
    $error = 0;
    //name main folder of user
    $folderprefix2 = getnamefoldertemp_session($iduser);
    //name actual folder with token
    $folderprefix = getnamesubfoldertemp_session($iduser, $token);
    //name of input file
    $ouputname = getnamefileoutputtemp_session($iduser,$token);
    //name of input file. num is string for replace to number of input
    $inputname = getnamefileinputtemp_session($iduser,$token);
    //name of error
    $errorname = getnamefileerror( $iduser, $token );

	/** EXECUTING CODE ***/
	$descriptorspec = array(
		0 => array("pipe", "r"),
		1 => array("pipe", "w"),
		2 => array("file", $errorname, "a")
	);
	
	//executing code 
	$process = proc_open('py.exe '. $nametemp, $descriptorspec, $pipes, null, null);
    $state = proc_get_status($process);
	
	//flag out or in 
	$flag = "out";
	//number of input
	$n_inputs = 0;
	
	//open output file
	fopen($ouputname, "w+");
							
    //while end of file								
	while( (!feof($pipes[1])) ){

        if(verifyErro($errorname,$ouputname) == 1){
                $error = 1;
                break;
            }

		
			//for outputs
			if($flag == "out"){	
				 
				//call output function
				$out = output($pipes[1]); 
				
				if($out!=null){
					//spliting lines
					$louts = split("\n", $out);
					//print this lines
					printlines($louts);
				
					//character hide is the signal to invert to input mode
					if(!empty($louts[count($louts)-1]))
						if($louts[count($louts)-1][0] == chr(0))
							$flag = "in";
					 
				}
			
			//for input
			}else {

                $localinputnme = str_replace(["num"], array($n_inputs), $inputname);
                if (file_exists($localinputnme)) {

                    //open input file
                    //call input function
                    $in = input($pipes[0]);
                    if ($in != 0)
                        //increment the input number
                        $n_inputs++;

                    //change flag to output mode
                    $flag = "out";

                }

            }
	}

    if(verifyErro($errorname,$ouputname) == 1){
        $error = 1;
    }

    $out = "";

    if($error != 0){
        $myfileerror = fopen($errorname, "r");
        $out = fread($myfileerror,filesize($errorname));
        fclose($myfileerror);
    }


    $typeerror = "";

    if($error != 0){

        if( is_array($out))
            $imp_str = implode(",",$out);
        else
            $imp_str = $out;

        $typeerror = preg_replace( "/\r|\n/", ",", $imp_str );
        $typeerror = str_replace( ",,", ",", $imp_str );
        $typeerror = str_replace("\\" , "\\\\" , $typeerror);
        $typeerror = str_replace("'" , "\'" , $typeerror );

    }


    $testpassed = $error==0?1:0;
    //Insert Compilations
    $query = "INSERT compilation VALUES (NULL, CURDATE() , CURTIME(), '$typeerror',  $idcode, NULL, NULL, -1)";
    $result = $mysqli->query($query);


    $result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $code2 = str_replace("'" , "\'" , $row['code']);

    //Copying Code in Compilations
    $query2 = "INSERT CodeCompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $mysqli->insert_id )";
    echo $query2;
    $result2 = $mysqli->query($query2);


    //call function to close process
    close();


    function close(){
		//open output file
		$myfile = fopen($GLOBALS["ouputname"], "a") or die("Unable to open file!");
		//send sing to end runing code
		fwrite($myfile, "__close\n");
		fclose($myfile);

		//close process			
		proc_close($GLOBALS["process"]);
		
	}
	
	//function to set input data in python
	function input($pipe){	
		
		$myfileinput = fopen($GLOBALS["localinputnme"], "r");	
		$input = fgets($myfileinput);		
		$r = fwrite($pipe, $input."\n");		
		fclose($myfileinput);
		
		return $r;
	}
	
	//function to save output data in file
	function output($pipe){
		
		if(feof($pipe))
			return null;
		
		$out = fread($pipe, 4096); 
		
		if($out != null){
			//open file in a mode
			$myfile = fopen($GLOBALS["ouputname"], "a");
			
			$string_sout = split("\n", $out);

			for($i=0; $i< count($string_sout); $i++){
				$local_str =trim(preg_replace('/\s\s+/', ' ', $string_sout[$i] ));
				if(empty($local_str))
					continue;
				
				//fwrite($myfile, date("H:i:s")." |". $local_str . "\n");
				fwrite($myfile,$string_sout[$i] . "\n");
			}
			
			fclose($myfile);
		}
		
		return $out;
	}
	
	
	function printlines($lines){
		for($i = 0; $i < count($lines); $i++){
			$local_str =trim(preg_replace('/\s\s+/', ' ', $lines[$i] ));
			if(empty($local_str) )
					continue;
				
			//echo "-".$lines[$i]. "<br>";
		}
	}

	function verifyErro($errorname,$ouputname){

        if( file_exists($errorname)  ){

            $myfileerror = fopen($errorname, "r");
            $error = fread($myfileerror, 4096);
            $local_str =trim(preg_replace('/\s\s+/', ' ', $error ));
            if(!empty($local_str) ){
                $my = fopen($ouputname, "a") or die("Unable to open file!");
                fwrite($my, "__error\n");
                fclose($my);

                return 1;
            }
        }

        return 0;
    }


	 
?>