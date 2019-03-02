<?php
include 'iotlib.php';

$dev = $_GET['dev'];
$pin = $_GET['pin'];
$value = $_GET['value'];

setPin($dev, $pin, $value);
?>
