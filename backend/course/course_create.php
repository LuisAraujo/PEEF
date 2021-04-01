<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$name = $_POST["newcoursename"];
$code = $_POST["newcoursecode"];
$key = $_POST["newcoursekey"];
$lang = $_POST["newcourselang"];


$sql = "INSERT INTO course (id,name,accesskey,Language_id, code,Professor_id) VALUES(null, '$name', '$key', '$lang', '$code', '".getcurrentuser_session()."')";
$result = $mysqli->query($sql);

if ($result)
    echo "1";
 else
    echo $sql ;



?>
