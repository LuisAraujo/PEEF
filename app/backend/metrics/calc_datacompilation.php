<?php
@require_once "../conection_database.php";


function getCountCompilations($idproject){
    $query = "SELECT count(*) as compilation FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = " . $idproject;
    $result = $GLOBALS['mysqli']->query($query);
    return  $result->fetch_assoc()["compilation"];
}

function getCountCompilationError($idproject)
{
    $query = "SELECT count(*) as complitaion FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = '" . $idproject . "' AND Compilation.typeError <> 'no-error'";
    $result = $GLOBALS['mysqli']->query($query);
    return $result->fetch_assoc()["complitaion"];
}

function getCountTests($idproject){
    $query = "SELECT count(*) as test FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = " . $idproject. " AND Compilation.testpassed <> -1 ";
    $result = $GLOBALS['mysqli']->query($query);
    return $result->fetch_assoc()["test"];
}


function getCountPassedTest($idproject){
    $query = "SELECT count(*) as test FROM Compilation INNER JOIN Code ON Compilation.Code_id = Code.id INNER JOIN Project ON Code.Project_id = Project.id  WHERE Project.id = " . $idproject. " AND Compilation.testpassed = 1 ";
    $result = $GLOBALS['mysqli']->query($query);
    return $result->fetch_assoc()["test"];
}

function getPercentPassedTest($idproject){
    return getCountPassedTest($idproject) * 100 /  getCountTests($idproject);
}
