<?php

include "iotlib.php";

$json = '{"ID":"relayBox1","D0":0,"D1":0,"D2":0,"D3":0,"D4":0,"D5":0,"D6":0,"D7":0,"D8":1}';

$secret = "8675309";

echo json_encode(getState('RelayBox1'));

setStateKey('RelayBox1', $json, sha1("$json$secret"));

echo json_encode(getState('RelayBox1'));


?>
