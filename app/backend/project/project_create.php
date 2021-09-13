<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idactivity = $_POST["idactivity"];

//if(getcurrentproject_session() == "null"){

    $query = "INSERT INTO `project` (`id`, `creationdate`, `date_lastmodification`, `hours_lastmodification`, `enhancedmessage`, `sended`, `iscorret`, `Enrollment_id`, `Estado_idEstado`, `Activity_id`) ".
"VALUES (NULL, CURDATE() , CURDATE(), '00:00:00', '1', '0', NULL, (SELECT id FROM Enrollment WHERE Course_id = '".getcurrentcourse_session()."' AND Student_id = '".getcurrentuser_session()."'), '1', '".$idactivity ."')";

    $result =  $mysqli->query($query);
    if($result){

        $query2 = "SELECT LAST_INSERT_ID() as id";
        $result2 =  $mysqli->query($query2);
        $row = $result2->fetch_assoc();
        echo $row["id"];
    }else
        echo "0";


//}else{  echo "0";}


