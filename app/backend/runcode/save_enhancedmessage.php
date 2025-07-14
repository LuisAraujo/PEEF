<?php
    header('Content-type: text/html; charset=utf-8');

    @include "../conection_database.php";

    $idcomp = $_POST["id"];
    $message = $_POST["message"];
    $message = str_replace( '"', '\"', $message);
    $message = str_replace( "'", "\'", $message);
    //Insert Compilation
    $query = "INSERT enhancedmessage (id, message, id_compilation) VALUES (NULL, '".$message."', '".$idcomp."')";
    $result = $mysqli->query($query);  
    $idinsered = $mysqli->insert_id;
    
    if($result)
       echo '{"status": "ok", "id": "'.$idinsered.'"}';
    else
        echo '{"status": "error"}';