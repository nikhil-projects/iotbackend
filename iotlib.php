<?php
require_once 'vendor/autoload.php';

include "db.php";
use ReallySimpleJWT\Token;
$secret = 'Hi!yssenBurgW154H3M365468792315982';


function getUserIDByOauthID($oauthid)
{
global $mysqli;

$sql = "select ID from users where oauthID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return null;
}
else{
 $stmt->bind_param('s',$oauthid);

if($stmt->execute() == true)
{

	$result = $stmt->get_result();
	return $result->fetch_assoc()['ID'];
}
else
{
return null;
}
}
}

function createUser($id, $fullname, $givenname, $familyname, $email, $imageurl, $oauthid)
{
global $mysqli;

$id =  generateRandomString(64);


	$sql = "insert into users(ID, fullName, givenName, familyName, email, imageURL, oauthID) values(?,?,?,?,?,?,?)";
	$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
return null;
}
else{
 $stmt->bind_param('sssssss',$id, $fullname, $givenname, $familyname, $email, $imageurl, $oauthid);

if($stmt->execute() == true)
{

        $result = $stmt->get_result();
	return $result;

}
else
{
return null;
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

function getDeviceOwner($devID)
{
global $mysqli;

$sql = "select owner from things where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return null;
}
else{
 $stmt->bind_param('s',$devID);

if($stmt->execute() == true)
{

        $result = $stmt->get_result();
        return $result->fetch_assoc()['owner'];
}
else
{
return null;
}

}
}

function getLoggedInUser()
{
	global $secret;
	$token = $_COOKIE['iot_login_token'];
	if($token != null)
	{
	$result = Token::validate($token, $secret);
	if($result)
	{
		$payload = Token::getPayload($token);
		$user = json_decode($payload,true)['user_id'];
		return $user;			
	}
	else
	{
		return 'invalid token';
	}
	}
	else return false;	
}

function checkIfAuthorized($devID)
{
	$userid = getLoggedInUser();
	
global $mysqli;

$sql = "select count(devID) AS instances from authUsers where devID = ? and userID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('ss',$devID, $userid);

if($stmt->execute() == true)
{
	//echo "executing statement<br>";
        $result = $stmt->get_result();
	//echo "got results<br>";
        $counts = $result->fetch_assoc()['instances'];
	//echo "$counts<br>";	
	if($counts >0)
		return true;

}
else
{
return false;
}

}
}


function setPin($devID, $pin, $value)
{
if(checkIfAuthorized($devID) && is_int($pin) && $pin >=0 && pin <=8)
{

global $mysqli;

$sql = "update thingCmd set D$pin=? where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
echo "sql: $sql =statement false";
 return false;
}
else{
 $stmt->bind_param('ss',$value, $devID);

if($stmt->execute() == true)
{       
        
return true;
}
else
{
return false;
}
}
}
else
return false;
}

function setPinMode($devID, $pin, $value)
{
if(checkIfAuthorized($devID) && is_int($pin) && $pin >=0 && pin <=8)
{

global $mysqli;

$sql = "update thingMode set D$pin=? where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('ss',$value, $devID);

if($stmt->execute() == true)
{

return true;
}
else
{
return false;
}
}
}
else
return false;
}


function getPin($devID, $pin)
{

global $mysqli;

$sql = "select * from thingState where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('s', $devID);

if($stmt->execute() == true)
{
	$result = $stmt->get_result();
	return $result->fetch_assoc()["D$pin"];
}
else
{
return false;
}
}
}

function getState($devID)
{

global $mysqli;

$sql = "select * from thingState where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('s', $devID);

if($stmt->execute() == true)
{
        $result = $stmt->get_result();
        return $result->fetch_assoc();
}
else
{
return false;
}
}
}

function getCmd($devID)
{

global $mysqli;

$sql = "select * from thingCmd where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('s', $devID);

if($stmt->execute() == true)
{
        $result = $stmt->get_result();
        return $result->fetch_assoc();
}
else
{
return false;
}
}
}
function getMode($devID)
{

global $mysqli;

$sql = "select * from thingMode where ID=?";
$stmt = $mysqli->prepare($sql);

if($stmt == false)
{
 return false;
}
else{
 $stmt->bind_param('s', $devID);

if($stmt->execute() == true)
{
        $result = $stmt->get_result();
        return $result->fetch_assoc();
}
else
{
return false;
}
}
}

function setStateKey($dev, $json, $checksum)
{
global $mysqli;

$sql = "select secret from things where ID=?";
$stmt = $mysqli->prepare($sql);


if($stmt == false)
{
return false;
}


else{
 $stmt->bind_param('s',$dev);

if($stmt->execute() == true)
{

        $result = $stmt->get_result();
        $secret = $result->fetch_array()[0];
}
else
{
return false;
}



$stmt->close();
}
if($secret == "")
{
return false;
}

$checkStr = "$json$secret";
if(sha1($checkStr) != $checksum)
{
return false;
}

setStateJSON($dev, $json);
}

function setStateJSON($dev, $json)
{
global $mysqli;

$sql = "update thingState SET D0=?, D1=?, D2=?, D3=?, D4=?, D5=?, D6=?, D7=?, D8=? where ID = ?";//10 arguments

$stmt = $mysqli->prepare($sql);

$newState = json_decode($json, true);

$D0 = $newState['D0'];
$D1 = $newState['D1'];
$D2 = $newState['D2'];
$D3 = $newState['D3'];
$D4 = $newState['D4'];

$D5 = $newState['D5'];
$D6 = $newState['D6'];
$D7 = $newState['D7'];
$D8 = $newState['D8'];

if($stmt == false)
{
return false;
}

else{
 $stmt->bind_param('iiiiiiiiis',$D0, $D1, $D2, $D3, $D4, $D5, $D6, $D7, $D8, $dev);

if($stmt->execute() == true)
{
}
else
{
return false;
}

}
}
?>

