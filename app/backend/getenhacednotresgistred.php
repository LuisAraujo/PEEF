<?php
/*Only for consulting type erros without enhanced message. */

@include "conection_database.php";

$query = "SELECT id, typeError, erromessage FROM `compilation` Where typeError <> 'no-error' and enhancedmessagefound = 0";
$result =$mysqli->query($query);
$array = [];
$i = 1;

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

   echo $i ." - ". $row["id"] ."," . $row["typeError"] .",".  $row["erromessage"]."<br><br>";
   $i++;
}


