<?php
@include "../conection_database.php";
@include "../session/manager_section.php";

$idproject = 1;

$query = "SELECT activity.id as id, activity.description, activity.title, activity.description_input ,  activity.description_output FROM activity WHERE id = (SELECT Activity_id FROM project WHERE id = ".  getcurrentproject_session().")";

$result = $mysqli->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
//echo json_encode($row);

$query2 = "SELECT * FROM test WHERE  Activity_id = ".$row["id"] ." LIMIT 2";
$result2 = $mysqli->query($query2);

$row2 = $result2->fetch_array(MYSQLI_ASSOC);
$input01 = str_replace( "\n", " <br> ", $row2["input"]);
$output01 = $row2["output"];

$row2 = $result2->fetch_array(MYSQLI_ASSOC);
$input02 = str_replace( "\n", " <br> ", $row2["input"]);
$output02 = $row2["output"];

$result = '{"id":"'.$row['id'].'","description":"'.$row['description'].'","title":"'.$row['title'].'","description_input":"'.$row['description_input'].'","description_output":"'.$row['description_output'].'","input01":"'.$input01.'","output01":"'.$output01.'","input02":"'.$input02.'","output02":"'.$output02.'"}';
echo  $result ;

?>