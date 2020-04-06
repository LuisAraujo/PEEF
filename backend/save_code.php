<?php
@include "conectionDataBase.php";

$idcode = $_POST["idcode"];
$code = $_POST["code"];

$code = str_replace("'" , "\'" , $code);

$result = $mysqli->query("UPDATE Code SET code = '".$code."' WHERE id = $idcode");

if($result){
    echo "ok";
}else {
    echo "erro";
}
?>