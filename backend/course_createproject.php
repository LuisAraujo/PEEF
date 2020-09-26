<?php
@include "conection_database.php";
/*criar projeto*/
/*criar code*/
$idactivity = 1;//$_POST["idactivity"];
$iduser = 1;//$_POST["iduser"];

$sql = "SELECT id FROM Project WHERE Enrollment_id = (SELECT id FROM Enrollment Where Student_id = $iduser And Course_id = (SELECT Course_id FROM Activity WHERE id = $idactivity ) AND Activity_id = $idactivity)";

$result = $mysqli->query($sql);

if(mysqli_num_rows($result) == 0) {

    $sql2 = "INSERT INTO Project (id,creationdate,date_lastmodification,hours_lastmodification, Enrollment_id,Activity_id) VALUES(null, CURDATE(), CURDATE(), CURTIME(), (SELECT id FROM Enrollment Where Student_id = $iduser And Course_id = (SELECT Course_id FROM Activity WHERE id = $idactivity )), $idactivity)";
    $result = $mysqli->query($sql2);
    echo $sql2;
    if ($result)
        echo "1";
     else
        echo "0";

}else
    echo "1";


?>
