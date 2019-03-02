<?php
include "iotlib.php";

$json = $_POST['json'];
$checksum = $_POST['checksum'];
$dev = $_POST['dev'];
setStateKey($dev, $json, $checksum);

echo getCmd();

?>
