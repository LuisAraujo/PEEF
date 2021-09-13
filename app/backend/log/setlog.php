<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$action = $_POST["action"];
$value = "";
if(isset($_POST["value"])) {

    $value = $_POST["value"];
}else {
    $idref = "";

    if (strcmp($action, "oncourse") == 0 || strcmp($action, "offcourse") == 0)
        $idref = getcurrentcourse_session();
    else if (strcmp($action, "inproject") == 0 || strcmp($action, "outproject") == 0 || strcmp($action, "indescription") == 0 )
        $idref = getcurrentproject_session();
    else
        $idref = "-1";
}


$query2 = "INSERT INTO log (id, Action_id, Enrollment_id, date, hours, id_ref) ";
if( strcmp( $value , ""))
    $query2 .= " VALUES (NULL,(SELECT id FROM Action WHERE name = '$action') , (SELECT id FROM Enrollment Where Student_id = '" . getcurrentuser_session(). "' AND Course_id = '". getcurrentcourse_session() ."'), CURDATE(), CURTIME(), '$value' )";
else
    $query2 .= " VALUES (NULL,(SELECT id FROM Action WHERE name = '$action') , (SELECT id FROM Enrollment Where Student_id = '" . getcurrentuser_session(). "' AND Course_id = '". getcurrentcourse_session() ."'), CURDATE(), CURTIME(), '$idref' )";

$result2 = $mysqli->query($query2);

echo $result2;

