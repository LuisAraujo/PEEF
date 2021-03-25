<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

//setcurrentcode_session( -1);

$query = "SELECT code.id as id FROM code WHERE code.Project_id = " . getcurrentproject_session() ;

$result = $mysqli->query($query);

if( $result->num_rows ==  0  ) {

    $query2 = "INSERT INTO code (id, name, code, Project_id)";
    $query2 .= " VALUES (NULL, 'mycode.py', 'print(\"Test Python\")', ". getcurrentproject_session() .")";
    $result2 = $mysqli->query($query2);


    echo json_encode("{'id' : '".$mysqli->insert_id."'}");


}else{

    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo json_encode($row);
}

?>