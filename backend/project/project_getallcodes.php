<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$result = $mysqli->query("SELECT id, name FROM code WHERE Project_id = ".  getcurrentproject_session());
$myArray = array();


while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $myArray[] = $row;
}

if( count($myArray) == 0){
    $query = "INSERT INTO code (id, name, Project_id) VALUES(null, 'mycode','".getcurrentproject_session()."')";

    $result2  = $mysqli->query($query);
    if($result2) {
        $query2 = "SELECT LAST_INSERT_ID() as is";
        $result3 = $mysqli->query($query2);
        $row["id"] = $result->fetch_assoc("id");
        $row["mycode.py"];
        $myArray[] = $row;
    }
}
echo json_encode($myArray);

return $result;

?>