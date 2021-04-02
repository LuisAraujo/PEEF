<?php

@include "../conection_database.php";
@include "../session/manager_section.php";

$idcourses = $_POST["courses"];
$title = $_POST["newclassname"];
$urlvideo = $_POST["urlvideo"];
$description = $_POST["description"];


$sql = "INSERT INTO classes (id,title,description,url, Course_id) VALUES(null, '$title', '$description', '$urlvideo', '$idcourses')";
$result = $mysqli->query($sql);

if ($result)
    echo "1";
 else
    echo  "0";



?>
