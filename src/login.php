<?php
	session_start();
	if(isset($_SESSION['log']) && $_SESSION['log'] == 'in') {
     	header('location:home.php');   
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
		<title>Placement Portal</title>
		<link rel="icon" href="images/fevicon.png" />
		<link type="text/css" rel="stylesheet" href="css/master.css" />
		<link type="text/css" rel="stylesheet" href="css/index.css" />
	</head>

	<body>
		<div id="headerlogo">
			<img src="images/placementlogo.png">
		</div>
<?php
			if(isset($_GET['resetneeded']) && $_GET['resetneeded'] == 'true')
				echo "<span id='error'>Your password needs to be generated before your first login.<br />Please contact the admin.</span>";
?>
		<div id="logintable">
			<form action="login_verify.php" method="post">
				<table border=0>
					<tr>
						<td>
							<img src="images/user.png">
						</td>
						<td>
							<input type="text" name="uname" required pattern="([0-9][0-9][cC][eE][uU][oOBbSsXxTt][gGsSnNfFtTDd][0-9][0-9][0-9]|[0-9][0-9][0-9][0-9][0-9][0-9]?)"
							id="nm" class="graybig" autocomplete="off" class="namehovered" autofocus placeholder="Username">
						</td>
					</tr>
					<tr>
						<td>
							<img src="images/lock.png">
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
                    <tr>
                    	<td>
                        </td>
                    	<td align="right">
                        	<a href="javascript:openWin();" id="txthelp">Need help?</a>
                        </td>
                    </tr>
				</table>
                <script type="text/javascript">
					var myWindow;

					function openWin()
					{
						myWindow = window.open("static/help.php","_parent","width=1000,height=600");
					}
				
				</script>
			</form>
			<!--TODO: Add help and forgot password-->
		</div>
        <p align="center">
		<footer id="footer">
			&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
		</footer>
		</p>
	</body>
</html>
