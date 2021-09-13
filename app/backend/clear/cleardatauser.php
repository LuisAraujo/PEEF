<?php

$id = 1;


//clear log
$sqldelete = "DELETE FROM Log WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id = $id)";
echo $sqldelete.";<br>";

//clear msg
$sqldelete = "DELETE FROM Message WHERE Project_id In (SELECT id FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id = $id))";
echo $sqldelete.";<br>";


//clear edit
$sqldelete = "DELETE FROM Lineedited WHERE CodeCompilation_id In (SELECT id FROM CodeCompilation WHERE Compilation_id In (SELECT id FROM compilation WHERE Code_id in (SELECT id FROM Code WHERE Project_id In (SELECT id FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id =$id) ))))";
echo $sqldelete.";<br>";

//clear code_compilation
$sqldelete = "DELETE FROM CodeCompilation WHERE Compilation_id In (SELECT id FROM compilation WHERE Code_id in (SELECT id FROM Code WHERE Project_id In (SELECT id FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id =$id) )))";
echo $sqldelete.";<br>";

//clear compilation
$sqldelete = "DELETE FROM compilation WHERE Code_id in (SELECT id FROM Code WHERE Project_id In (SELECT id FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id =$id) ))";
echo $sqldelete.";<br>";

//clear code
$sqldelete = "DELETE FROM Code WHERE Project_id In (SELECT id FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id =$id) )";
echo $sqldelete.";<br>";

//clear project
$sqldelete = "DELETE FROM Project WHERE Enrollment_id In (SELECT id FROM Enrollment WHERE Student_id =$id) ";
echo $sqldelete.";<br>";