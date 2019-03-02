<?php

$servername = "localhost";
$username = "iotuser";
$password = "IHateRules";

//echo "connecting";
$mysqli = new mysqli($servername, $username, $password);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mysqli->select_db("iot");

?>
