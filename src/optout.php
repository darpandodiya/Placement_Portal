<?php
	
	require("functions/isloggedin.php");
    require("functions/gettable.php");

    //-----Database connection for cities-----
    //require('functions/getdbcon.php');
	$con = getConnection();
	$flag=true;
	if(isset($_POST['submit'])){
		if(isset($_POST['optout'])){
			if($_POST['optout']==1){
				mysqli_query($con,"UPDATE $candidates set opting=false where id='".$_SESSION['username']."'");
				$flag=false;
			}
			else{
				mysqli_query($con,"UPDATE $candidates set opting=true where id='".$_SESSION['username']."'");
				$flag=true;
			}
		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Opt Out | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="css/master.css" />
<link type="text/css" rel="stylesheet" href="css/optout.css" />

<link rel="icon" href="images/fevicon.png" />
</head>

<body>
<header id="header">
				<img src="images/placementlogoSmall.png">
		</header>
        	<a href="home.php">
			<table id="home">
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
			</table></a>
		<p id="heading">
			Opt Out for Placement
		</p>
        <?php 

				$result = mysqli_query($con,"SELECT * FROM $candidates where id='".$_SESSION['username']."'");
				$temp=mysqli_fetch_array($result);
				if($temp['opting']==true && $flag==true){

			        echo '<form action="#" method="post">
        			    <p class="notice">
                			<input type="checkbox" name="optout" value="1" required id="opti">
							<label for="opti" id="label"> I don\'t want to participate in placement drive.</label><br>
                			<input type="submit" name="submit" value="Submit" id="submit" alt="Think twice">
            			</p>
			        </form>';
				}
				else{
					echo '<form action="#" method="post">
        			    <p class="notice">
            				<input type="checkbox" name="optout" value="0" required id="opti">
							<label for="opti" id="label"> I want to participate in placement drive.</label><br>
                			<input type="submit" name="submit" value="Submit" id="submit" alt="Think twice">
            			</p>
			        </form>';
				}
        ?>
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>