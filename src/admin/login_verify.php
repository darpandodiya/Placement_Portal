<?php
	require("../functions/checkAdminUserPass.php");
	require('../functions/gettable.php');

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
		
		if(!isAdminUsernameValid($username))
			$success = false;
		else
			$success = checkAdminUserPass($username, $password);
		
		if(!$success)
		{
			header('Location: login.php?incorrect=true');
			exit(0);
		}
		session_start();
		$_SESSION['admin_log']='in';
		$_SESSION['admin']='true';
		$_SESSION['username']=$username;
		header('Location: home.php');
		exit(0);
	}

	header('Location: login.php?incorrect=true');
	exit(0);
?>