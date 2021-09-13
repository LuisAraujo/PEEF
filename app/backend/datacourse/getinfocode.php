<?php
@include "../conection_database.php";

if(isset( $_POST["idproject"]))
    $idproject = $_POST["idproject"];

$query = "SELECT code.id, code.code, Compilation.id, Compilation.typeerror, Compilation.lineerror, compilation.testpassed, Compilation.erromessage, Compilation.erromessage, compilation.enhancedmessagefound FROM code LEFT JOIN Compilation ON Compilation.Code_id = Code.id WHERE code.Project_id = $idproject ORDER BY compilation.id DESC LIMIT 1";

$result = $mysqli->query($query);

if ($result)
    echo json_encode($result->fetch_array(MYSQLI_ASSOC));
else
    echo "0";