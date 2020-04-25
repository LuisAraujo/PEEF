<?php
@include "conection_database.php";
@include "manager_section.php";

$idproject = 1;//$_POST["idproject"];

$query = "SELECT * FROM Activity WHERE id = (SELECT Activity_id FROM Project WHERE id = ".  getcurrentproject_session().")";

$result = $mysqli->query($query);
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)) {

    $myArray[] = $row;
}
echo json_encode($myArray);

return $result;

?>