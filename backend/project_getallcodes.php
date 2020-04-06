<?php
@include "conectionDataBase.php";

$result = $mysqli->query("SELECT id, name FROM Code Where Code.Project_id = 1;");
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $myArray[] = $row;
}
echo json_encode($myArray);

return $result;


?>