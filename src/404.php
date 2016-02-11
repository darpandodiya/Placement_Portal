<?php
  header("HTTP/1.0 404 Not Found");
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>404 Not Found | Placement Cell</title>

		<link type="text/css" rel="stylesheet" href="/Dropbox/Placement%20Project/Source/css/master.css" />
		<link type="text/css" rel="stylesheet" href="/Dropbox/Placement%20Project/Source/css/error.css" />

		<link rel="icon" href="/Dropbox/Placement%20Project/Source/images/error.png" />                

	</head>
	<body>
	    <header id="header">
			<img src="/Dropbox/Placement%20Project/Source/images/placementlogoSmall.png">
		</header>
    
	    <img src="/Dropbox/Placement%20Project/Source/images/error.png" />
		<h4>
			404 Not Found
		</h4>
        <div class="instructions">
	    	Sorry, we coudn't find the resource you requested because it doesn't exist at
            <strong><?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?></strong> <br />
	        If you were brought here through a link, it must be broken.
		</div>
        <?php session_start();
		 if(isset($_SESSION['admin'])){ ?>
		<a href="/Dropbox/Placement%20Project/Source/admin/login.php"> 
        <?php }else { ?>
        <a href="/Dropbox/Placement%20Project/Source/login.php"> <?php }?>
			<h3>
				Back to Home Page
			</h3>
		</a>

    	<footer id="footer">
			&copy;&nbsp;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
		</footer>   
	</body>
</html>