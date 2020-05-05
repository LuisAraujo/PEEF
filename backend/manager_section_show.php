<?php

session_start();

echo "Current user: ".$_SESSION['currentuser']. "<br>";
echo "Current course: ". $_SESSION['currentcourse']. "<br>";
echo "Current project: ".$_SESSION['currentproject']. "<br>";
echo "Current code: ".$_SESSION['currentcode']. "<br>";


?>