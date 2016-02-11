<?php
function isloggedin()
{
	session_start();
	return (isset($_SESSION['username']) && isset($_SESSION['log']) &&  $_SESSION['log'] == 'in' ? true : false);
}

if (!isloggedin())
{
	session_destroy();
	header("location: error.php");
	exit(0);
}
?>