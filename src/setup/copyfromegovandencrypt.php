<?php
$host = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$srctablename = 'data_from_egov';
$desttablename = 'candidates';
$connection = mysqli_connect($host, $dbusername, $dbpassword, 'projectdb');
//mysqli_select_db($connection, 'projectdb') or die(mysqli_error());
if (mysqli_connect_errno())
{
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	exit(0);
}

$q = 'SELECT `ID`, `rollno`, `Name`, `password`, `contact`, `email`, `city`, `preferred_city`, `ssc`, `hsc`, `diploma`, `SPI_1`, `SPI_2`, `SPI_3`, `SPI_4`, `SPI_5`, `SPI_6`, `CPI`, `address`, `pref_techs`, `skills` FROM ' . $srctablename;
$result = mysqli_query($connection, $q);
$total=0;


$doencrypt=false;
if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'encrypt')
	$doencrypt=true;

//if ($doencrypt)
//{
	while($data = mysqli_fetch_array($result))
	{
		$total++;
		if ($doencrypt)
		{
			$password = $data[0];
			$cost = 10;
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", $cost) . $salt;
			$hash = crypt($password, $salt);
			
			for($i = 8; $i <= 17; $i++)
			{
				if (!$data[$i])
					$data[$i] = "''";
			}
			$q2 = "INSERT INTO candidates(id, name, hashedpass, has_logged_once, rollno, contact, email, city, preferred_city, ssc, hsc, diploma, spi_1, spi_2, spi_3, spi_4,spi_5, spi_6, cpi, address, preferred_techs, skills, opting) VALUES ('$data[0]','$data[2]','$hash',0,'$data[1]',$data[4],'$data[5]','$data[6]','$data[7]',$data[8],$data[9],$data[10],$data[11],$data[12],$data[13],$data[14],$data[15],$data[16],$data[17],'','','',1)";
			//echo $q2 . "<br/>";
			mysqli_query($connection, $q2);
		}
	} 
//}
mysqli_close($connection);
?>
<!doctype html>
<html>
	<head><title>Encrypt passwords</title></head>
	<body>
		<div align="center">
			<h3>
            	This script copies the data from the table 'data_from_egov' to 'candidates'. <br />
                Use this file only as a tool. Do NOT make this available to the end user in any link or redirect!
            </h3>
			Total entries in the source table - <?php echo $total; ?><br />
			Click "GO" to encrypt the passwords and copy the records.<br />
			WARNING! There will be no way to decipher the passwords!<br />
			<input type=button value="GO" onclick="window.location='copyfromegovandencrypt.php?do=encrypt';">
		</div>
	</body>
</html>