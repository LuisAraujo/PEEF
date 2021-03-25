<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$email = "luisaraujo.ifba@gmail.com";
$message =  "Link de chat: <a href='www.peefonline.com/teacher/chat?id=".getcurrentproject_session()."'>www.peefonline.com/teacher/chat?id=".getcurrentproject_session()."</a>";
$subject =  "New message in PEEF";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: PEEF <no-reply@peefonline.com>';

// send email
if(mail($email,$subject,$message,$headers))
    echo "1";
else
    echo "0";
?>