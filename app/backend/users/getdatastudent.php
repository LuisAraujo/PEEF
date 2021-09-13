<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idstudent = $_POST["idstudent"];

$sql = "SELECT name, email, bio, SEXY_id as sexy, sis_language.id as idlang, sis_language.cod as cod FROM student LEFT JOIN sis_language ON sis_language.id = language_id WHERE student.id = ".$idstudent;

$result = $mysqli->query($sql);

$row = $result->fetch_array(MYSQLI_ASSOC);

$path = "../../";
$imageurl = "imageprofile/". md5(getcurrentuser_session());
if(is_dir($path.$imageurl))
    $myfiles = array_diff(scandir($path.$imageurl), array('.', '..'));


if(file_exists($path. $imageurl))
   $row["urlprofile"] = $imageurl."/".$myfiles[2];
else
   $row["urlprofile"] = "imageprofile/default/profile.png";

echo json_encode($row);

?>