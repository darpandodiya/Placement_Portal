<?php
	require('functions/gettable.php');
	require('functions/checkUserPass.php');
	function getHashedPass($password)
	{
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost) . $salt;
		return crypt($password, $salt);
	}
?>
<!DOCTYPE html>
<html>
	<head>
    	<title>Change Password | Placement Cell</title>
		<link href="css/master.css" rel="stylesheet" type="text/css" />
		<link href="css/changeps.css" rel="stylesheet" type="text/css" />
		<link rel="icon" href="images/fevicon.png" />
	</head>
	<body>
		<header id="header">
			<img src="images/placementlogoSmall.png">
		</header>
		<p id="heading">
			Change Password
		</p>
<?php
	if(isset($_GET['success']))
	{
?>
		<div align="center" id="success">
        	Password has been updated.
            <br />
        </div>
        <div align="center">
        	Go to <a href="home.php">Home</a>
        </div>
        <br/><br/>
	   	<footer id="footer">
			&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	   	</footer>
	</body>
</html>
<?php
		exit(0);
	}
	session_start();
	if(isset($_SESSION['firstlogin']))
	{
?>
		<a href="logout.php">
			<table id="home">
				<tr>
					<td>
						<img src="images/logout.png" alt="Logout" width="48px" height="48px">
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							Logout
						</strong>
					</td>
				</tr>
			</table>
		</a>

		<div align="center">Since you are accessing this system for the first time, you need to change your password.<br>
			Your new password must contain at least 8 characters.<br /> It is compulsory to have in your password atleast 1 lowercase, 1 uppercase, 1 digit and 1 special character.
			<br>e.g. p@\$\$w0Rd
		</div>
<?php

	}
	else
	{
		if (!(isset($_SESSION['username']) && isset($_SESSION['log']) &&  $_SESSION['log'] == 'in')) //not logged in
		{
			session_destroy();
			header("location: error.php");
			exit(0);
		}
?>
		<a href="home.php">
			<table id='home'>
				<tr>
                    <td>
                        <img src='images/home.png' alt='Home' />
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>
                            Home
                        </strong>
                    </td>
                </tr>
            </table>
        </a>
        <div align="center">
			Your new password must contain at least 8 characters.<br /> It is compulsory to have in your password atleast 1 lowercase, 1 uppercase, 1 digit and 1 special character.
			<br>e.g. p@\$\$w0Rd
		</div>
<?php
	}
	
	if(isset($_POST['curr_pass']) && isset($_POST['con_pass']) && isset($_POST['new_pass']))
	{
		$con = getConnection();
		$username = $_SESSION['username'];
		$currpass = $_POST['curr_pass'];
		$newpass = $_POST['new_pass'];
		$conpass = $_POST['con_pass'];
		if (!checkUserPass($username, $currpass))
		{
?>
		<div align="center">
        	<span id="error">
				Incorrect password entered.
            </span>
        </div>
<?php	
		}
		else if ($newpass != $conpass)
		{
?>
		<div align="center">
        	<span id="error">
            	Entered passwords do not match.
            </span>
        </div>
<?php	
		}
		else if (!isStrong($newpass))
		{
?>
		<div align="center">
        	<span id="error">
            	Password is not strong enough.
            </span>
        </div>

<?php
		}
		else
		{
			$hashedpass = getHashedPass($newpass);
			mysqli_query($con,"UPDATE $candidates SET hashedpass = '" . $hashedpass . "' WHERE id = '" . $username . "'");

			if(isset($_SESSION['firstlogin']))
			{
				unset($_SESSION['firstlogin']);
				$_SESSION['log']='in';
				mysqli_query($con,"UPDATE $candidates SET has_logged_once = 1 WHERE id = '" . $_SESSION['username'] . "'");
			}
			mysqli_close($con);
			
			header("location: changepassword.php?success=true");
			exit(0);
		}
	}
?>
		<div align='center'><br /><br />
			<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post'>
				<table id='formtable' cellspacing='3px' cellpadding='5px'>
					<tr>
                        <td>
                            <label for='currps'>
                                Current Password:
                            </label>
                        </td>
                        <td>
                            <input type='password' class='graybig' id='currps' name='curr_pass' placeholder='Current Password' autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nps">
                                New Password:
                            </label>
                        </td>
                        <td>
                            <input type='password' name='new_pass' required id='nps' class='graybig' placeholder='New Password'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cps">
                                Confirm Password:
                            </label>
                        </td>
                        <td>
                            <input type='password' name='con_pass' required id='cps' class='graybig' placeholder='Confirm Password'>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align='right'>
                            <input type='submit' name='submit' value='Update' id='submit'>
                        </td>
	     	  		</tr>
	   			</table>
			</form>
        </div>
	   	<br/><br/>
	   	<footer id="footer">
			&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	   	</footer>
	</body>
</html>