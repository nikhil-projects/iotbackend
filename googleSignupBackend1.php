<?php
require_once 'vendor/autoload.php';
include "db.php";


$id_token = $_POST['idtoken'];

$client = new Google_Client(['290195616061-o388q70kko75rap924seng1345hjo3cu.apps.googleusercontent.com' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
  //echo $payload;

foreach($payload as $key => $item)
{
//echo "$key => $item<br>";
}
  // If request specified a G Suite domain:
  //$domain = $payload['hd'];
} else {
  // Invalid ID token
//echo "invalid token";
}
$sql = "select count(ID) from users where oauthID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
die("prepare returned false");
}
else{
 $stmt->bind_param('s',$userid);

if($stmt->execute() == true)
{

        $result = $stmt->get_result();
        $recordcount = $result->fetch_array()[0];
}
else
{
echo "failure";
}
if($recordcount != 0)
{
die("exists");
//put prettier redirect here at some point
}
else
{
$id = generateRandomString(64);
//| fullName   | varchar(64)  | YES  |     | NULL    |       |
//| givenName  | varchar(64)  | YES  |     | NULL    |       |
//| familyName | varchar(64)  | YES  |     | NULL    |       |
//| email      | varchar(128) | YES  |     | NULL    |       |
//| imageURL   | varchar(128) | YES  |     | NULL    |       |
//| oauthID    | varchar(64)  | YES  |     | NULL    |       |
$id =  generateRandomString(64);
$oauthid = $payload['sub'];
$email = $payload['email'];
$fullname = $payload['name'];
$givenname = $payload['given_name'];
$familyname= $payload['family_name'];
$imageurl = $payload['picture'];

$sql = "insert into users(ID, fullName, givenName, familyName, email, imageURL, oauthID) values(?,?,?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
die("failure");
}
else{
 $stmt->bind_param('sssssss',$id, $fullname, $givenname, $familyname, $email, $imageurl, $oauthid);

if($stmt->execute() == true)
{

        $result = $stmt->get_result();
	echo "success";
}
else
{
echo "failure";
}

}
}
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
