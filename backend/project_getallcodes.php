<?php
@include "conectionDataBase.php";

$result = $mysqli->query("SELECT * FROM Code Where Code.Project_id = 1;");
$mysqli -> close();

return $result;


?>