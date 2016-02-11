<?php
    require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    require('../functions/randompass.php');

    $con = getConnection();
    
    if(isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
		$query1 = "SELECT * FROM $candidates WHERE has_logged_once='0' AND id='" . $id . "'";
        $result1 = mysqli_query($con, $query1);
		if(mysqli_num_rows($result1) > 0)
		{
			echo "Specified id doesn't exist or the password is alredy reset!\n";
	        header("Location:randompassword.php"); 
			exit(0);
		}
        $pass = generate_password();
        $query = "UPDATE $candidates SET has_logged_once=0, hashedpass='$pass' WHERE id='" . $id . "'";
		$result = mysqli_query($con, $query);
        header("Location:randompassword.php"); 
		exit(0);
    }
	header("Location:randompassword.php"); 
	exit(0);
?>