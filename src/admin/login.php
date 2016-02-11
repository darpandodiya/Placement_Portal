<?php
	session_start();
	if(isset($_SESSION['admin_log']) && $_SESSION['admin_log'] == 'in') {
		if(isset($_SESSION['admin']))
		{
			header('location: home.php'); //adminhome
			exit(0);	
		}
     	header('location: ../home.php'); //candidate home
     	exit(0);
	}
	else {
		session_destroy();
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Admin Login | Placement Cell</title>
		<link rel="icon" href="../images/fevicon.png" />
		<link type="text/css" rel="stylesheet" href="../css/master.css" />
		<link type="text/css" rel="stylesheet" href="../css/index.css" />
	</head>

	<body>
		<div id="headerlogo">
			<img src="../images/placementlogo.png">
		</div>
		<div id="logintable">
			<form action="login_verify.php" method="post">
				<table border=0>
					<tr>
						<td>
							<img src="../images/user.png">
						</td>
						<td>
							<input type="text" name="uname" required pattern="^[a-zA-Z0-9\_\-]+$"
							id="nm" class="graybig" autocomplete="off" class="namehovered" autofocus placeholder="Username">
						</td>
					</tr>
					<tr>
						<td>
							<img src="../images/lock.png">
						</td>
						<td>
							<input type="password" name="pass" required placeholder="Password" class="pass_not_hovered" id="ps" class="graybig">
						</td>
					</tr>
                    <tr>
                    <td></td>
                    	<td class="error_not_disp">
                    		<?php
								if(isset($_GET['incorrect']) && $_GET['incorrect'] == 'true')
								{
									echo "<span id='error'>Username/Password is Incorrect</span>";
								}
							?>
                        </td>
                    </tr>
					<tr>
                    	<td>
                    	</td>
						<td>
							<input type="submit" name="submit" value="Login" id="login">
                        </td>
					</tr>
				</table>
			</form>
		</div>
        <p align="center">
		<footer id="footer">
			&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
		</footer>
		</p>
	</body>
</html>
