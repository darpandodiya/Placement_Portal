<html>
	<head><title>Regex Test</title></head>
    <body>
    	<form action="#" method="get">
        	Username:<input type="text" name="uname" value="<?php if(isset($_GET['uname'])) echo $_GET['uname'];?>" autofocus />
            <h3 style="color:red" >
            
            

<?php
	require("checkAdminUserPass.php");
	if(isset($_GET['uname']))
	{
		if(isAdminUsernameValid($_GET['uname']))
			echo "Valid";
		else
			echo "Invalid";
	}
?>
			</h3>
            <input type="submit" value="Test" />
		</form>
	</body>
</html>