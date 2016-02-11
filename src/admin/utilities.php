<?php
	require('../functions/isadminloggedin.php');
	require('../functions/gettable.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Utilities | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/adminutilities.css" />

<link rel="icon" href="../images/fevicon.png"/>
</head>

<body>
<header id="header">
				<img src="../images/placementlogoSmall.png">
		</header>
      
      <a href="home.php">  
        <table id="home" onClick="window.location='home.php'">
                <tr>
                    <td>
                        <img src="../images/home.png" alt="Home">
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <strong>
                            Panel
                        </strong>
                    </td>
                </tr>
            </table>
       </a>
		<p id="heading">
			Utilities
		</p>
        
        <div id="utilitiestable">
		
        <table border="0" align="center" cellpadding="20" id="utilities" name="services">
            <tr>
               <td width="128">
                	<a href="changepassword.php">
                    <table class="tabs">
                    <tr><td>
                    	<img src="../images/key.png" alt="Change Password" title="Change Password">
                        <div align="center" id="texts">Change<br> Password</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128">
                	<a href="sql.php">
                    <table class="tabs">
                    <tr><td>
                    	<img src="../images/sql.png" alt="Fire SQL Query" title="Fire SQL Query">
                        <div align="center" id="texts">Fire SQL<br>Query</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128">
                	<a href="randompassword.php">
                    <table class="tabbs">
                    <tr><td>
                    	<img src="../images/randompassword.png" alt="Random Password" title="Random Password">
                        <div align="center" id="texts">Generate<br> Random Password</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128">
                	<a href="backup.php">
                    <table class="tabs">
                    <tr><td>
                    	<img src="../images/backup.png" alt="backup" title="Backup Database" height="100px" width="90px">
                        <div align="center" id="texts">Backup <br>Data</div>
                    </td></tr></table>
                    </a>
                </td>
            </tr>
              
        </table>
    </div>
        
<footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>