<?php
	require('functions/checkUserPass.php');
	require('functions/gettable.php');
	
	if(!isset($_POST['uname']) || !isset($_POST['pass']))
	{
		header('location:error.php');
		exit();
	}
	
	// Check connection
	if(isset($_POST['submit']))
	{
		$username = $_POST['uname'];
		$password = $_POST['pass'];
		
		if(!isIDValid($username))
			$success = false;
		else
		{
			//Check if user has logged once
			$con = getConnection();
			$result = mysqli_query($con, "SELECT has_logged_once, name FROM $candidates where id='" . $username . "'");
			$data = mysqli_fetch_array($result);
			if(mysqli_num_rows($result) == 1)
			{
				if($data[0] == 0)
					$first = true;
				else
					$first = false;
			}
			$name = $data['name'];
			mysqli_close($con);
			$success = checkUserPass($username, $password);
		}
		if(!$success)
		{
			header('Location: login.php?incorrect=true');
			exit(0);
		}
		session_start();
		$_SESSION['name'] = $name;
		$_SESSION['username'] = $username;
		if($first)
		{
			$_SESSION['firstlogin'] = 'true';
			header('Location: changepassword.php');
			exit(0);
		}
		else
		{
			$_SESSION['log'] = 'in';
			header('Location: home.php');
			exit(0);
		}
	}

	header('Location: login.php?incorrect=true');
	exit(0);
?>