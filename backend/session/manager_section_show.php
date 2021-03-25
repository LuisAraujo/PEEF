<?php

session_start();
//session_unset();


echo "Current user: ".$_SESSION['currentuser']. "<br>";
echo "Type user: ".$_SESSION['typeuser']. "<br>";
echo "Current course: ". $_SESSION['currentcourse']. "<br>";
echo "Current project: ".$_SESSION['currentproject']. "<br>";
echo "Current code: ".$_SESSION['currentcode']. "<br>";


?>