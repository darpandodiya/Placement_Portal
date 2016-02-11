<?php
	require('functions/isloggedin.php');
	require('functions/gettable.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Export PDF | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="css/master.css" />
<link type="text/css" rel="stylesheet" href="css/exportpdf.css" />

<link rel="icon" href="images/fevicon.png" />
</head>

<body>
<header id="header">
				<img src="images/placementlogoSmall.png">
		</header>
      
      <a href="home.php">  
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
		<p id="heading">
			Export To PDF
		</p>
        
        <?php
			$con=getConnection();
			$result = mysqli_query($con,"SELECT * FROM $candidates where id='".$_SESSION['username']."'");
			$temp=mysqli_fetch_array($result);
			
			//True if registration form is filled. False otherwise. Set this variable accordingly.
			
			if($temp['contact']!=0) $isFilled = true;
			else $isFilled = false;
			
			if($isFilled) {
				 echo "<a href='functions/generatepdf.php' target='_blank'>
				 		<table align='center' class='download'>
						<tr><td>
							<img src='images/pdf.png'>
                          
							 <p>Download</p>
						</td></tr>
						</table>
						</a>";	
			}
			else {
				echo "<div class='downloadhidden'>
						<p align='center'>This feature will be available only when your registration details get submitted.</p>
					  </div>";
			}
		?>      
        
        
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>