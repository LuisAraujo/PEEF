<?php
    header('Content-type: text/html; charset=utf-8');

    include 'getnamestemp.php';
    @include "manager_section.php";
    @include "../conection_database.php";
    @include  "../identify_errotype.php";
    @include  "../get_enhanced_message.php";

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
    //get file of enhanced message
    $enhancedmessagename = getnamefileenhacedmessage( $iduser, $token );
    $reportname = getnamefilereport_session($iduser, $token );

	/** EXECUTING CODE ***/
	$descriptorspec = array(
		0 => array("pipe", "r"),
		1 => array("pipe", "w"),
		2 => array("file", $errorname, "a")
	);
	
	//executing code 
	//window
    $process = proc_open('py.exe '. $nametemp, $descriptorspec, $pipes, null, null);
    $state = proc_get_status($process);
	
	//flag out or in. Started in out
	$flag = "out";
	//number of input
	$n_inputs = 0;
	//time limit of wainting interation
	$timelimit = 20;
	//get initial time
	$timestart = strtotime("now");
	
	//open output file
	fopen($ouputname, "w+");

	$report = fopen($reportname, "w");

    //while end of file								
	while( (!feof($pipes[1])) ){
        fwrite($report, "looping\n");
	    //get current time for count limit
		$timecurrent = strtotime("now");

        //check limit
        $time = $timecurrent - $timestart;
        fwrite($report, "time ".$time."\n");


		if( $time >= $timelimit){
            fwrite($report, "end ".$time."\n");
			echo "fim";
			timeout();
			break;
		}

        //has error?
        if(verifyErro($errorname,$ouputname) == 1){
            fwrite($report, "error ".$time."\n");
            $error = 1;
            echo "0";
            break;
        }

		
        //for outputs
        if($flag == "out"){
            fwrite($report, "out ".$time."\n");
            //call output function
            $out = output($pipes[1]);

            if($out!=null){
                //spliting lines
                $louts = split("\n", $out);

                //depreciate print this lines
                //printlines($louts);

                //character hide is the signal to invert to input mode
                if(!empty($louts[count($louts)-1]))
                    if($louts[count($louts)-1][0] == chr(0))
                        $flag = "in";

            }

            //for input
        }else {
            fwrite($report, "in ".$time."\n");
            //save replaced name file
            $localinputnme = str_replace(["num"], array($n_inputs), $inputname);

            //exists?
            if (file_exists($localinputnme)) {

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

    fclose($report);

	//verify erro tag
    if($error != 1){

        if(verifyErro($errorname,$ouputname) == 1){
            $error = 1;
            echo "0";
        }
    }

    $out = "";
    $erromessage = "";
    $myfileenhanced = "";

    if($error != 0){

        //ope file error
        $myfileerror = fopen($errorname, "r");
        $out = fread($myfileerror,filesize($errorname));
        fclose($myfileerror);

        if( is_array($out))
            $imp_str = implode(",",$out);
        else
            $imp_str = $out;

        //
        $erromessage = preg_replace( "/\r|\n/", ",", $imp_str );
        //change imp_str to erromessage??
        $erromessage = str_replace( ",,", ",", $imp_str );
        $erromessage = str_replace("\\" , "\\\\" , $erromessage);
        $erromessage = str_replace("'" , "\'" , $erromessage );

    }else{
        echo "1";
    }

    //get type error
    $typeerror = checkErroType($erromessage);
    //flag found enhaced message
    $enhacedmessagefound = 0;
    //get enhaced message in array
    $enhaceddata = getEnhancedMessage( $typeerror );
    $idenhacedmessage = $enhaceddata[0];
    $enhacedmessage = $enhaceddata[1];

   //open enhacedmessage file and insert message
   if( strlen($enhacedmessage) > 0) {

        $myfileenhanced = fopen($enhancedmessagename, "w+");
        $out2 = fwrite($myfileenhanced, $enhacedmessage);
        fclose($myfileenhanced);
        $enhacedmessagefound = 1;
    }

    /* INSERT DATA EXECUTATION IN DATABASE */

    $testpassed = $error==0?1:0;

    //Insert Compilation
    $query = "INSERT compilation VALUES (NULL, CURDATE() , CURTIME(), '$erromessage',  $idcode, '".$typeerror[0]."', '".$typeerror[1]."', '".$typeerror[2]."', -1, '".$idenhacedmessage."', '')";
    $result = $mysqli->query($query);
    //save id complitaion inserted
    $idinsered = $mysqli->insert_id;

    //select name and code of this executed code
    $result = $mysqli->query("SELECT name, code FROM code Where id = $idcode;");
    $row = $result->fetch_array(MYSQLI_ASSOC);

    //replace code
    $code2 = str_replace("'" , "\'" , $row['code']);

    //Copying to Code in Compilations
    $query2 = "INSERT CodeCompilation VALUES (null, '".$row['name']."',' ".$code2." ', 0, $idinsered )";
    //echo $query2;
    $result2 = $mysqli->query($query2);

    //call function to close process
    close();

    /* @name close
     * @desc open output file and insert close tag
    */
    function close(){
		//open output file
		$myfile = fopen($GLOBALS["ouputname"], "a") or die("Unable to open file!");
		//send sing to end runing code
		fwrite($myfile, "\n__close\n");
		fclose($myfile);

		//close process			
		proc_close($GLOBALS["process"]);
		
	}

    /* @name input
     * @desc function to set input data in python
     * @return resource
     */
	function input($pipe){	
		
		$myfileinput = fopen($GLOBALS["localinputnme"], "r");	
		$input = fgets($myfileinput);
        $input=  utf8_decode($input);
		$r = fwrite($pipe, $input."\n");
		fclose($myfileinput);
		
		return $r;
	}

    /* @name output
     * @desc function to save output data in output file
     * @return resource
     */
	function output($pipe){
		
		if(feof($pipe))
			return null;
		//read pipe
		$out = fread($pipe, 4096); 
		
		if($out != null){
			//open file in a mode a
			$myfile = fopen($GLOBALS["ouputname"], "a");
			
			$string_sout = split("\n", $out);

			for($i=0; $i< count($string_sout); $i++){
				$local_str =trim(preg_replace('/\s\s+/', ' ', $string_sout[$i] ));


				if( !count($local_str) && (empty($local_str)))
					continue;

                $string_sout[$i] = $string_sout[$i];
                //$string_sout[$i] = utf8_decode($string_sout[$i]);
                //write in file
                if( strcmp( "<<", substr($string_sout[$i], 1,2)) == 0)
                    //add \n if input string: << examples
                    fwrite($myfile, $string_sout[$i]. "\n" );
                else
                    fwrite($myfile, $string_sout[$i]);

			}
			
			fclose($myfile);
		}
		
		return $out;
	}

	/* @name timeout
	 * @desc open file of output and insert timrout tag
	 * */
	function timeout(){
		//open output file
		$myfile = fopen($GLOBALS["ouputname"], "a") or die("Unable to open file!");
		//send sing to end runing code
		fwrite($myfile, "\n__timeout\n");
		fclose($myfile);
		
		//close process			
		proc_close($GLOBALS["process"]);
		
	}

	/* @name enhacedmessege
     * @param enhancedmessagename (enhanced message file name), $enhacedmessage (enhanced message)
     * @desc open enhanced message file and insert enhanced message
     * @return bool
     */
	function enhacedmessege($enhancedmessagename, $enhacedmessage){
        $found = 0;
        if( strlen($enhacedmessage) > 0) {

            $myfileenhanced = fopen($enhancedmessagename, "w+");
            fwrite($myfileenhanced, $enhacedmessage);
            fclose($myfileenhanced);
            $found = 1;
        }

        return  $found;

    }
	/* @name printlines
     * @param lines (linhas of files)
	 * */
	function printlines($lines){
		for($i = 0; $i < count($lines); $i++){
			$local_str =trim(preg_replace('/\s\s+/', ' ', $lines[$i] ));
			if(empty($local_str) )
					continue;
		}
	}

    /* @name verifyError
     * @param errorname (name of file with error information), outputname (name of output file)
     * @desc: verify if has a error end insert tag error in output file
     * @return int
     */
	function verifyErro($errorname,$ouputname){

        if( file_exists($errorname)  ){

            $myfileerror = fopen($errorname, "r");
            $error = fread($myfileerror, 4096);
            $local_str =trim(preg_replace('/\s\s+/', ' ', $error ));

            if(!empty($local_str) ){

                $my = fopen($ouputname, "a") or die("Unable to open file!");
                fwrite($my, "\n__error\n");
                fclose($my);

                return 1;
            }

            fclose($myfileerror);
        }

        return 0;
    }


?>