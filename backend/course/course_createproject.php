<?php
@include "conection_database.php";
/*criar projeto*/
/*criar code*/

$idactivity = $_POST["idactivity"];
$iduser = $_POST["iduser"];

$sql = "SELECT id FROM project WHERE Enrollment_id = (SELECT id FROM enrollment Where Student_id = $iduser And Course_id = (SELECT Course_id FROM activity WHERE id = $idactivity ) AND Activity_id = $idactivity)";

$result = $mysqli->query($sql);

if(mysqli_num_rows($result) == 0) {

    $sql2 = "INSERT INTO project (id,creationdate,date_lastmodification,hours_lastmodification, Enrollment_id,Activity_id) VALUES(null, CURDATE(), CURDATE(), CURTIME(), (SELECT id FROM enrollment Where Student_id = $iduser And Course_id = (SELECT Course_id FROM activity WHERE id = $idactivity )), $idactivity)";
    $result = $mysqli->query($sql2);
    echo $sql2;
    if ($result)
        echo "1";
     else
        echo "0";

}else
    echo "1";


?>
