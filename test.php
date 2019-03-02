<?php
include 'vendor/autoload.php';

use ReallySimpleJWT\Token;

$userId = 12;
$secret = 'sec!ReT423*&1';
$expiration = time() + 3600;
$issuer = 'localhost';

$token = Token::getToken($userId, $secret, $expiration, $issuer);

// Validate the token
$result = Token::validate($token, $secret);
echo $token;
?>
