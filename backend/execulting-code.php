<?php
//EXTRATOR DE ERROS
$namefile = $_POST["filename"]; //"file"; //mudar para parâmetro

//$cmd = 'python '.$namefile.'.py 2>&1';
$cmd = 'python '.$namefile.' 2>&1';

$output = exec($cmd, $out, $error);

if($error == 0){
	print("<span class='alert'> Program Compiled with Sucess! </span> <br><br>");
	
	foreach($out as $o)
		print "> " .$o;
}else{ 
	print("<b>Error founded! <br> </b>");
	foreach($out as $o){
		$outsplited = split(",", $o);
		foreach($outsplited as $os)
			print $os . "<br>";
			
			//executar regex para identificar os nomes
				//file
				//error
		
	}

}


?>