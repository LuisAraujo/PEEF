<?php
/*ESTE CODIGO NÃO É MAIS NECESSÁRIO NESTA VERSÃO*/

    header('Content-type: text/html; charset=utf-8');

    @include "../conection_database.php";

    $idenhanced = $_POST["id"];
    $value = $_POST["value"];
   
    $query = "UPDATE enhancedmessage SET  id_option_eval = '$value' WHERE id = '$idenhanced'";
    $result = $mysqli->query($query);  
    $idinsered = $mysqli->insert_id;
    
    if($result)
       echo '{"status": "ok", "id": "'.$idinsered.'"}';
    else
        echo '{"status": "error"}';
?>