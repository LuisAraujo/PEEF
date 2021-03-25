<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$result = $mysqli->query("SELECT id, name FROM code WHERE Project_id = ".  getcurrentproject_session());
$myArray = array();

while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $myArray[] = $row;
}
echo json_encode($myArray);

return $result;

?>