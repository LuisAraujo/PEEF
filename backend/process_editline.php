<?php
echo "<title>Jadud’s Error Quotient (EDIT LOCATIOn)</title>";
@include "conection_database.php";
@include "calc_stringedit.php";

$idactivity = 1;

$query = "SELECT id FROM Project WHERE Activity_id = $idactivity";
$result = $mysqli->query($query);


while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

    $query2 = "SELECT Compilation.id as id, CodeCompilation.id as codeid, code FROM Compilation INNER JOIN CodeCompilation ON CodeCompilation.Compilation_id = Compilation.id WHERE CodeCompilation.linesedited = 0 AND Code_id = (SELECT id FROM Code WHERE Project_id = ".$row["id"]."  LIMIT 1)";

    $result2 = $mysqli->query($query2);
    $oldcode = "";

    while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
        echo "old = " .$oldcode . "<br>";
        echo "cur = ". $row2["code"]."<br><br>";

        //$lines = array( array(-1,-1) );

        $lines = comparation_lines($row2["code"], $oldcode );

        for( $i = 0; $i < count($lines); $i++) {
            $query3 = "INSERT INTO LineEdited VALUES(NULL, " . $lines[$i][0] . ", " . $lines[$i][1] . " ," . $row2["codeid"] . ")";
            echo $query3. "<br>";
            $result3 = $mysqli->query($query3);
        }

        $query4 = "UPDATE CodeCompilation SET linesedited = 1 WHERE  id = ".$row2["codeid"];
        $result4 = $mysqli->query($query4);

        $oldcode = $row2["code"];
    }
}


?>