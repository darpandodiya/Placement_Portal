<?php
	require('../functions/isadminloggedin.php');
	require('../functions/gettable.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel | Placement Portal
    </title>
    	<link href="../css/master.css" rel="stylesheet" type="text/css">
		<link href="../css/adminhome.css" rel="stylesheet" type="text/css">
        
        <link rel="icon" href="../images/fevicon.png" />                
	</head>

	<body>
    
    <header id="header">
				<img src="../images/placementlogoSmall.png">
	</header>
    
	<h2 id="adminheading">
		Admin Panel
	</h2>
	
    <h3 id="welcome">
    	Welcome, <?php echo $_SESSION['username'];?>
    </h3> 
    
    <div id="servicestable">
		
        <table align="center" cellpadding="20" id="services" name="services">
        	
            <tr>
            	<td width="128px">
                	<a href="managedatabase.php">
                	<table class="images">
                    <tr><td>
                    	<img src="../images/database.png" alt="Database Management" title="Database Management">
                        <div align="center" id="niche">Database<br> Management</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128px">
                	<a href="explorerecords.php">
                	<table class="images">
                    <tr><td>
                    	<img src="../images/search.png" alt="Explore Records" title="Explore Records">
                        <div align="center" id="niche">Explore Records</div>
                    </td></tr></table>
                    </a>
                </td>
                
                <td width="128px">
                	<a href="eventmanagement.php?action=view">
                	<table class="images">
                    <tr><td>
                    	<img src="../images/event.png" alt="Event Management" title="Event Management">
                        <div align="center" id="niche">Event Management</div>
                    </td></tr></table>
                    </a>
                </td>
                                
                <td width="128px">
                	<a href="utilities.php">
                	<table class="images">
                    <tr><td>
                    	<img src="../images/settings.png" alt="Utilities" title="Utilities">
                        <div align="center" id="niche">Utilities</div>
                    </td></tr></table>
                    </a>
                </td>
                <td width="128px">
                	<a href="logout.php">
                	<table class="images">
                    <tr><td>
                    	<img src="../images/logout.png" alt="Logout" title="Logout">
                        <div align="center" id="niche">	Logout</div>
                    </td></tr></table>
                    </a>
                </td>
            </tr>
    
    <footer id="footer">
		&copy; 2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    
	</body>
    
    
</html>