<?php
	
	require('functions/isloggedin.php');
	require('functions/gettable.php');
?>

<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<title>Settings | Placement Cell
    </title>
    	<link href="css/master.css" rel="stylesheet" type="text/css">
		<link href="css/utilities.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="images/fevicon.png" />                
	</head>

	<body>
    
    <header id="header">
				<img src="images/placementlogoSmall.png">
	</header>
    
	<p id="heading">
		Settings
	</p>
	
    <a href="home.php" title="Home">
        <table id="home" onClick="window.location='home.php'">
                <tr>
                    <td>
                        <img src="images/home.png" alt="Home">
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <strong>
                            Home
                        </strong>
                    </td>
                </tr>
        </table>
     </a>
		
    <div id="utilitiestable">
		
        <table border="0" align="center" cellpadding="20" id="utilities" name="services">
        	
            <tr>
            	
               <td width="128">
                	<a href="optout.php">
                    <table class="tabs">
                    <tr><td>
                    	<img src="images/optout.png" alt="Opt Out" title="Opt Out">
                        <div align="center" id="texts">Opt out of<br>Placements</div>
                    </td></tr></table>
                    </a>
                </td>
                
                <td width="128">
                	<a href="changepassword.php">
                    <table class="tabs">
                    <tr><td>
                    	<img src="images/key.png" alt="Change Password" title="Change Password">
                        <div align="center" id="texts">Change<br>Password</div>
                    </td></tr></table>
                    </a>
                </td>
                
            </tr>
                            
        </table>
        
    </div>
    
    <footer id="footer">
		&copy; 2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    
	</body>
    
    
</html>