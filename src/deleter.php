<?php
	require('functions/isloggedin.php');
	if(isset($_POST['remove1'])){
		unlink('photos/'.md5($_SESSION['username'],false).'.jpg');
	}
		header('location:reg.php');
		exit();
?>