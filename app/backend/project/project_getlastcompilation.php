<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$query = "SELECT Compilation.typeerror, Compilation.lineerror FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id  INNER JOIN Project ON Project.id = Code.Project_id WHERE Project.id = ".  getcurrentproject_session()." ORDER BY Compilation.id DESC LIMIT 1";

$result = $mysqli->query($query);

if($result){
    echo json_encode($result->fetch_array(MYSQLI_ASSOC));
}else{
    echo "0";
}

?>