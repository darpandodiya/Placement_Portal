<?php
	require('functions/isloggedin.php');
    require('functions/gettable.php');
	$con = getConnection();
	$query="SELECT * from $event";
	$result=mysqli_query($con,$query);
	//$temp=mysqli_fetch_array($result);
	
?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Notifications | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="css/master.css" />
<link type="text/css" rel="stylesheet" href="css/notifications.css" />

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
			Notifications
		</p>
        
        <?php
            if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add') {
                $sql1 = "INSERT INTO $xref (`sid`, `eid`) VALUES ('".$_REQUEST['sid']."', '".$_REQUEST['eid']."')";
                $result2 = mysqli_query($con, $sql1);

//                print_r($sql1);   

                header("Location:notifications.php?applysuccess=true");
                
            }
            
            if(isset($_REQUEST['applysuccess']) && ($_REQUEST['applysuccess']='true')) {
                echo "
                    <center>
                        Applied successfully.
                    </center>";
            }
        ?>
        
        <?php
             
            if(mysqli_num_rows($result) == 0) {
                echo "
                    <center>
                        No notifications.
                    </center>";
            }
			else{
        ?>
   <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->     
   <div align="center" id="listContainer">
            <ul id="expList">
            <?php
                $flag=0; 
				while($rows = mysqli_fetch_array($result)){
					if($rows['ispublished']){
                        $flag++;
						
			?>
                <li style="vertical-align:top;">
                <img id="pl" src="images/plus.png" style="margin-top:4px;">
				<img id="min" src="images/minus.png" style="margin-top:4px;">
					&nbsp;&nbsp;&nbsp;<?php echo $rows['name'];?>
                    <ul id="k">
                    	<li>
                            Type: <?php echo $rows['type'];?>
                        </li>
                        <li>
                            Date: <?php echo $rows['date'];?>
                        </li>
                        <li>
                            Time: <?php echo $rows['time'];?>
                        </li>
                        <li>
                            Description: <?php echo $rows['description'];?>
                        </li>
                        <li><div>
                            <?php
                                $studentid = $_SESSION['username'];
	                            $eventid = $rows['id'];
                                $argument = "appl($studentid, $eventid)";    
                            ?>
                            Eligibility: <?php echo $rows['eligibility'];?></div>
                            
                            <?php
                                $sql3 = "SELECT * FROM `$xref` WHERE `sid`='".$_SESSION['username']."' AND `eid`='".$rows['id']."'";
                                //print_r($sql3);
                                $result3 = mysqli_query($con, $sql3);
                                
                                if(mysqli_num_rows($result3) == 1) {
                                    echo "<div align='right'><button value='You've already applied for this event.' style='width:300px; font-family:OpenSans; font-size:16px; background-color: #AAA; cursor:not-allowed;' >You've already applied for this event</button></div>"; 
                                }
                                else {
                                    echo "<div align='right'><button value='Apply' onClick=\"".$argument."\" style='cursor:pointer'>Apply</button></div>";    
                                }
                            ?>

                        </li>
                    </ul>
                </li>

            <?php 
                }
            }
        ?>
            </ul>
        </div>
		<?php
			if($flag==0) {
                echo "<center>No notifications.</center>";    
            }
            }
		
		?>	
        
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    	<script>
		function appl(sid, eid){
			if(confirm('You sure you want to proceed ?\nThis is irreversible action.')) {
			    window.location = "notifications.php?action=add&sid="+ sid +"&eid="+eid;
            }
			else {}
		}
		</script>
        <script type="text/javascript" src="js/jquery-2.0.1.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
</body>
</html>