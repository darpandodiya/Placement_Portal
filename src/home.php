<?php
	require("functions/isloggedin.php");
    require('functions/gettable.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Home | Placement Cell
    </title>
    	<link href="css/master.css" rel="stylesheet" type="text/css">
		<link href="css/home.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="images/fevicon.png" />
	</head>

	<body>
    
    <header id="header">
				<img src="images/placementlogoSmall.png">
	</header>
    
    <h3 id="welcome">
    	Welcome, 
        <?php
			echo $_SESSION['name'];
		?>
    </h3> 
    
    <br><br><br><br>
    <div id="servicestable">
		
        <table align="center" cellpadding="20" id="services" name="services">
        
            
        	
            <tr>
            
                <td width="128px">
                	<a href="notifications.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/bell.png" alt="Notifications" title="Notifications">
                        <div align="center" id="niche">Notifications</div>
                    </td></tr></table>
                    </a>
                </td>
                
            	<td width="128px">
                	<a href="reg.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/profileupdate.png" alt="Profile Management" title="Profile Management">
                        <div align="center" id="niche">	Profile<br> Management</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128px">
                	<a href="cvupload.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/cvupload.png" alt="CV Management" title="CV Management">
                        <div align="center" id="niche">	CV Management</div>
                    </td></tr></table>
                    </a>
                </td>
                
                <td width="128px">
                	<a href="exportpdf.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/export2pdf.png" alt="Export To PDF" title="Export To PDF">
                        <div align="center" id="niche">	Export to PDF</div>
                    </td></tr></table>
                    </a>
                </td>
                
                <td width="128px">
                	<a href="utilities.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/settings.png" alt="Settings" title="Settings">
                        <div align="center" id="niche">	Settings</div>
                    </td></tr></table>
                    </a>
                </td>
				
                <td width="128px">
                	<a href="logout.php">
                	<table class="images">
                    <tr><td>
                    	<img src="images/logout.png" alt="Logout" title="Logout">
                        <div align="center" id="niche">	Logout</div>
                    </td></tr></table>
                    </a>
                </td>
            </tr>
            

        </table>
        
    </div>
    
    <footer id="footer">
		&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    
	</body>
    
    
</html>