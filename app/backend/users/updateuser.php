<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$name = $_POST["username"];
$sexy = $_POST["sexy"];
$bio = $_POST["bio"];
$language = $_POST["language"];
$password = $_POST["password"];


$sql = "UPDATE Student SET name = '$name', SEXY_id = '$sexy', bio = '$bio', Language_id = '$language'  ";

if($password){

    $sql .= ", password = md5('$password') ";
}

$sql .= "WHERE id = ".getcurrentuser_session();
$result =  $mysqli->query($sql);

if($result) {
    $path = "../../imageprofile/". md5(getcurrentuser_session());

    if(!is_dir($path)) {
        mkdir($path,  0700);
    }

    if($_FILES['image']['size'] != 0 ) {
        $imageurl = $path . "/profile." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $imageurl)) {
            echo "1";
        } else {
            echo "0";
        }
    }else{
        echo "1";
    }

}else
    echo "0";