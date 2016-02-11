<?php
	require('../functions/isadminloggedin.php');
	require('../functions/gettable.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Fire SQL Query | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/sql.css" />

<link rel="icon" href="../images/fevicon.png" />
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
           Fire SQL Query
       </p>
    
       <div id="inputbox">
           <form action="" method="post">
               <table align="center">
                    <tr>
                       <td valign="middle">
                            <input type="text" required name="query" placeholder="Type SQL Query Here" autocomplete="on" autofocus id="inputquery">
                       </td>
                       <td valign="middle">
                            <input type="submit" name="fire" value="Fire" id="submitquery">
                       </td>
                    </tr>
               </table>
           </form>
       
       </div>
       
       <?php
            if(isset($_POST['fire'])) {

                $con = getConnection();
                $query = $_POST['query'];
                
                $result = mysqli_query($con, $query);
                
                echo "<p id=\"query\">Your Query: $query</p><br><br>";
                echo '<p id="res" >Query Result:</p> ';
                if(!$result)
				{
					echo "Failed - " . mysqli_error($con) . "<br>";
				}
				else if($result === true)
				{
					echo "Successful.";
				}
				else
				{
		?>
        <div id="results" align="center">
        <table class="searchtable" cellpadding="2" cellspacing="3">
        	<tr class="trr">
            	<?php
					$finfo = mysqli_fetch_fields($result);
					foreach ($finfo as $val)
						echo "<td class=\"bold\">" . $val->name . "</td>";
				?>
            </tr>
        	<?php
					while($data=mysqli_fetch_array($result, MYSQLI_ASSOC))
					{
						echo "<tr>";
						foreach ($data as $key => $value)
							echo "<td>$value</td>";
						echo "</tr>";
					}
					mysqli_free_result($result);
			?>
        </table>
        </div>
        <?php
				}
            }
       ?>
		
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>