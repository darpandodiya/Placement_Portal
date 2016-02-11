<?php
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$tablename = 'aaddmmiinn';
$connection = mysqli_connect($host, $dbusername, $dbpassword, 'projectdb');
//mysqli_select_db($connection, 'projectdb') or die(mysqli_error());
if (mysqli_connect_errno())
{
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$q = 'SELECT * FROM ' . $tablename;
$result = mysqli_query($connection, $q);
$total=0;

$doencrypt=false;
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'encrypt')
  $doencrypt=true;

while($data = mysqli_fetch_array($result))
{
	$total++;
	if ($doencrypt)
	{
		$password = $data['hashedpass'];
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		$hash = crypt($password, $salt);
		
		$q='UPDATE ' . $tablename . ' SET hashedpass=\'' . $hash . '\' where username=\'' . $data['username'] . '\'';
		mysqli_query($connection, $q);
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
            	This script encrypts the passwords in the admin table. <br />
                Use this file only as a tool. Do NOT make this available to the end user in any link or redirect!<br />
                Do NOT run this script twice as it will rehash the passwords.
            </h3>
			Total passwords in the table - <?php echo $total; ?><br>
			Click "GO" to encrypt the passwords.<br>
			WARNING! There will be no way to decipher the passwords.<br>
			<input type=button value="GO" onclick="window.location='encryptadmindb.php?do=encrypt';">
		</div>
	</body>
</html>