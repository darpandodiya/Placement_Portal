<?php
function isadminloggedin()
{
	session_start();
	return (isset($_SESSION['admin']) && isset($_SESSION['admin_log']) &&  $_SESSION['admin_log'] == 'in' ? true : false);
}

if (!isadminloggedin())
{
	session_destroy();
	header("location: ../error.php");
	exit(0);
}
?>