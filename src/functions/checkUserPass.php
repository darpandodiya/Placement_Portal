<?php


function checkUserPass($username, $password)
{
	$host = 'localhost';
	$dbusername = 'root';
	$dbpassword = '';
	$databasename = 'projectdb';
	$tablename = $GLOBALS['candidates'];
       
	$mysqli = new mysqli($host, $dbusername, $dbpassword, $databasename);
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		return false;
	}
	
	if (!($stmt = $mysqli->prepare('SELECT has_logged_once, hashedpass FROM ' . $tablename . ' WHERE id = ? LIMIT 1'))) {
	    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		return false;
	}
	if (!$stmt->bind_param("s", $username)) {
	    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		return false;
	}
	if (!$stmt->execute()) {
	    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		return false;
	}
	
	if (!$stmt->bind_result($hasloggedonce, $hashedpass)) {
		echo "Binding result set failed: (" . $stmt->errno . ") " . $stmt->error;
		return false;
	}
	
	if (!$stmt->fetch())
	{
		$mysqli->close();
		return false;
	}
		
	if ($hasloggedonce == 0)
	{
		if(!strcmp($hashedpass, $password))
			return true;
		else
			return false;
	}
	
	// Hashing the password with its hash as the salt returns the same hash
	if ( crypt($password, $hashedpass) == $hashedpass )
	{
		$success = true;
	}
	else
	{
		$success = false;
	}
	$mysqli->close();
	return $success;
}

function isIDValid($id)
{
	return (preg_match('/^([0-9][0-9][cC][eE][uU][oOBbSsXxTt][gGsSnNfFtTDd][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9]?)$/', $id) ? true : false);
}

function isStrong($password)
{
	if (strlen($password) < 8) return false;
	if (!preg_match('/[A-Z]/', $password)) return false;
	if (!preg_match('/[a-z]/', $password)) return false;
	if (!preg_match('/[0-9]/', $password)) return false;
	if (!preg_match('/[,.<>?:;\'"`~!@#$%^&*()\\\_\-=+\[\]\/]/', $password)) return false;
	return true;
}
?>