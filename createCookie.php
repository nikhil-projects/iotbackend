<?php
require_once 'vendor/autoload.php';
require_once 'iotlib.php';

use ReallySimpleJWT\Token;


$token = $_GET['token'];
//$userid = "testuser";
$redirectURL = $_GET['dest'];
//$redirectURL = "https://foc-electronics.com";


$client = new Google_Client(['290195616061-o388q70kko75rap924seng1345hjo3cu.apps.googleusercontent.com' => $CLIENT_ID]);
$payload = $client->verifyIdToken($token);

if($payload)
{
$userid = getUserIDByOauthID($payload['sub']);



$secret = 'Hi!yssenBurgW154H3M365468792315982';
$expiration = time()+(3600*24*30);

$issuer = 'foc-electronics.com';
$token = Token::getToken($userid, $secret, $expiration, $issuer);
//echo $token;
setcookie('iot_login_token', $token, time() + 60*60*24*30, '/');


header("Location: $redirectURL");
}
else
{
die("invalid token");
}
?>
