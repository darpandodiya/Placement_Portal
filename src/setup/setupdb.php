<?php
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$tablename = 'candidates';
$connection = mysqli_connect($host, $dbusername, $dbpassword, 'projectdb');
if (mysqli_connect_errno())
{
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit(0);
}

$q = 'SELECT count(*) FROM ' . $tablename;
$result = mysqli_query($connection, $q);
$data = mysqli_fetch_array($result);
$total=$data[0];

$doencrypt=false;
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'encrypt')
	$doencrypt=true;

if ($doencrypt)
{
	$q = 'SELECT id FROM ' . $tablename;
	$result = mysqli_query($connection, $q);
	
	while($data = mysqli_fetch_array($result))
	{
		$password = $data['id']; //set password = id for now
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		$hash = crypt($password, $salt);
		
		//TODO: (JOEL) Complete this:
		$q2 = "UPDATE $tablename SET has_logged_once=0, hashedpass='$hash' WHERE id = $data[0]";
		mysqli_query($connection, $q2);
	}
}
mysqli_close($connection);
?>
<!doctype html>
<html>
	<head><title>Encrypt passwords</title></head>
	<body>
		<div align="center">
			<h3>
            	This script resets table 'candidates' to an initial state. <br />
                Use this file only as a tool. Do NOT make this available to the end user in any link or redirect!
            </h3>
			Total entries in the source table - <?php echo $total; ?><br />
			Click "GO" to reset all passwords and has_logged_once states and clear the user input fields.<br />
			WARNING! There will be no way to decipher the passwords!<br />
			<input type=button value="GO" onclick="window.location='setupdb.php?do=encrypt';">
		</div>
	</body>
</html>