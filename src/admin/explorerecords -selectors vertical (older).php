<?php
	require('../functions/isadminloggedin.php');
	require('../functions/getdbcon.php');
	$con = getConnection();
	$citie = "SELECT * from cities";
	$hometowns = mysqli_query($con, $citie);
	$prefcities = mysqli_query($con, $citie);
     
	if(isset($_GET['submit'])){
        $temphometown = $_GET['hometown'];
        if($temphometown == 'all') {
           $temphometown = ''; 
        }
        $tempprefcity = $_GET['pref_city'];
        if($tempprefcity == 'all') {
           $tempprefcity = ''; 
        }
        $optingquery = '';
        if($_GET['opting'] == '1') {
            $optingquery = "and opting = 1";
        }
        else if($_GET['opting'] == '0') {
            $optingquery = "and opting = 0";
        }
        
        
		$sqlquery = "SELECT * 
					from candidates 
					where name like '%".$_GET['name']."%' 
					and city like '%$temphometown%'
			 		and preferred_city like '%$tempprefcity%'
					and (hsc between ".$_GET['hscfrom']." and ".$_GET['hscto'].")
		            and (ssc between ".$_GET['sscfrom']." and ".$_GET['sscto'].")
		            and (diploma between ".$_GET['diplomafrom']." and ".$_GET['diplomato'].")
                    and (cpi between ".$_GET['cpifrom']." and ".$_GET['cpito'].")
                    and (spi_".$_GET['selected-sem']." between ".$_GET['spifrom']." and ".$_GET['spito'].")
                    ".$optingquery;
		
        
		$res1 = mysqli_query($con, $sqlquery);
        
        //echo "<br><br>$sqlquery<br><br>";
        //print_r($res1);
        
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Explore Records</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/explorerecords.css" />

<link rel="icon" href="../images/search.png"/>
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
		<div id="heading">
			Explore Records
		</div>
        
        <div align="center">
        <form method="get" action="#">
        
        	<div id="selectors">
            <table cellspacing="2" cellpadding="2">
            <tr><td>
            <label for="nm">Search by Name :</label></td><td> <input type="text" id="nm" name="name" autofocus /></td></tr>
            <tr><td>
            <label for="ht">Hometown :</label></td><td> <select name="hometown" id="ht">
                <?php echo "<option value='all' selected>All</option>";
				
	                       while($rows = mysqli_fetch_array($hometowns)){
							   
							   if($rows['hometown']=='') break;
			                   else echo "<option value='".$rows['hometown']."'>". $rows['hometown'] ."</option>";
                           }
	                       echo "</select>";
                ?></td></tr>
                <tr><td>
            <label for="pc">Preferred City :</label></td><td> <select name="pref_city" id="pc">
            	<?php echo "<option value='all' selected>All</option>";

	                       while($rows = mysqli_fetch_array($prefcities)){
							   
							   if($rows['prefcity']=='') break;
			                   else echo "<option value='".$rows['prefcity']."'>". $rows['prefcity'] ."</option>";
                           }
	                       echo "</select>";
                ?></td></tr>
                <tr><td>
             <label for="ssc">SSC :</label></td><td>
				From <input id="from1" name="sscfrom" type="number" value="0"> to <input id="to1" name="sscto" type="number" value="100"></td></tr>
                
                <tr><td>
             <label for="hsc">HSC :</label></td><td>
				From <input id="from1" name="hscfrom" type="number" value="0"> to <input id="to1" name="hscto" type="number" value="100"></td></tr>
                
                <tr><td>
             <label for="diploma">Diploma :</label></td><td>
				From <input id="from1" name="diplomafrom" type="number" value="0"> to <input id="to1" name="diplomato" type="number" value="100"></td></tr>
                
                <tr><td colspan="2">
             		College Results:
             	</td></tr>
                
                <tr><td>
             <label for="cpi">CPI :</label></td><td>
						From <select name="cpifrom" id="from1">
                               <?php $i; for($i=0; $i<=9.5; $i=$i+0.5) echo "<option value='$i'>$i</option>";?>
                             </select>
              			to   <select name="cpito" id="from1">
                                <?php 
                                    $i; 
                                    for($i=0.5; $i<=10; $i=$i+0.5) {
                                        if($i==10) {
                                            echo "<option value='$i' selected>$i</option>";
                                            continue;
                                        }
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                             </select>
                </td></tr>
                
                 <tr><td>
             <label for="avgspi">Avg. SPI :</label></td><td>
						From <select name="avgspifrom" id="from1">
                                <?php $i; for($i=0; $i<=9.5; $i=$i+0.5) echo "<option value='$i'>$i</option>";?>
                             </select>
              			to   <select name="avgspito" id="from1">
                                <?php 
                                    $i; 
                                    for($i=0.5; $i<=10; $i=$i+0.5) {
                                        if($i==10) {
                                            echo "<option value='$i' selected>$i</option>";
                                            continue;
                                        }
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                             </select>
                </td></tr>
                
                 <tr><td colspan="2">
             		In particular Semester:<select name="selected-sem" id="from1">
                                                <?php $i; for($i=1; $i<=6; $i++) echo "<option value='$i'>$i</option>";?>
                                             </select>
             	</td></tr>
                
                <tr><td>
             <label for="spi">SPI :</label></td><td>
						From <select name="spifrom" id="from1">
                               <?php $i; for($i=0; $i<=9.5; $i=$i+0.5) echo "<option value='$i'>$i</option>";?>
                             </select>
              			to   <select name="spito" id="from1">
                                <?php 
                                    $i; 
                                    for($i=0.5; $i<=10; $i=$i+0.5) {
                                        if($i==10) {
                                            echo "<option value='$i' selected>$i</option>";
                                            continue;
                                        }
                                        echo "<option value='$i'>$i</option>";
                                    }
                                ?>
                             </select>
                </td></tr>
                
                <tr><td>
             <label for="pref-techs">Preferred<br> Technologies :</label></td><td>
						<input type="checkbox" name="preftechs" id="pref-techs" value="html" checked >HTML</input>&nbsp;
						<input type="checkbox" name="preftechs" id="pref-techs" value="java" checked >Java</input>
						<input type="checkbox" name="preftechs" id="pref-techs" value="sql" checked >SQL</input><br>
						<input type="checkbox" name="preftechs" id="pref-techs" value="python" checked >Python</input>
                        <input type="checkbox" name="preftechs" id="pref-techs" value="php" checked >PHP</input>
						<input type="checkbox" name="preftechs" id="pref-techs" value="dotnet" checked >.NET</input><br>
						<input type="checkbox" name="preftechs" id="pref-techs" value="c" checked >C</input>
						<input type="checkbox" name="preftechs" id="pref-techs" value="css" checked >CSS</input>
                        <input type="checkbox" name="preftechs" id="pref-techs" value="javascript" checked >JavaScript</input><br>

                </td></tr>
                
                <tr><td>
             <label for="opt">Opting for<br> placement :</label></td><td>
						<input type="radio" name="opting" id="opt" value="1" >Opting</input><br>
						<input type="radio" name="opting" id="opt" value="0" >Non-Opting</input><br>
                        <input type="radio" name="opting" id="opt" value="all" checked >Both</input>

                </td></tr>
                <tr>
                    <td colspan="2" align="right">
             			<input type="submit" name="submit" value="Explore" class="input">
                    </td>
                    <!--<td>    
                        <input type="reset" name="reset" value="Reset" id="input"/>
                    </td>-->
                </tr>
                </table>
                </form>
           </div>
        	
        
        	<div id="results">
                
                <h4 align="center" id="heads">
                    Search Results
                </h4>
                
                
                <table border="0" cellpadding="5" cellspacing="5" class="searchtable">
                   
                   <?php if(isset($res1)) echo "<tr> <td colspan='5' class='bold bold1'>".mysqli_num_rows($res1)."  result(s) found.</td></tr>
							   <tr><td colspan='5' bgcolor='#E8E8E8'><hr color='#000'></hr></td></tr>";
					  else {
						  $con = getConnection();
                            $x=0;
                            $else = "SELECT * from candidates";
                            $elseres = mysqli_query($con, $else);
							
							echo "<tr> <td colspan='5' class='bold bold1'>".mysqli_num_rows($elseres)."  result(s) found.</td></tr>
							   <tr><td colspan='5' bgcolor='#E8E8E8'><hr color='#000'></hr></td></tr>";
					  }
				?>
                   
                    
                    <tr bgcolor="#0066FF">
                        <td width="25px" class="bold" >Index</td>
                        <td width="300px" class="bold">Name</td>
                        <td width="100px" class="bold">ID</td>
                        <td width="120px" class="bold">View/Edit</td>
                        <td width="100px" class="bold">Remove</td>
                    </tr>
                    <tr>
                     <td colspan='5' bgcolor="#E8E8E8"></td></tr>
                    <?php
                        if(isset($res1)){
                            $x=0;
							
							
                            while($rows = mysqli_fetch_array($res1)){
                               $x++;
							   mysqli_num_rows($res1);
                               echo "<tr>
                                        <td>".$x."</td>                                        
                                        <td>".$rows['name']."</td>
                                        <td>".$rows['id']."</td>
                                        <td><a href='view.php?view=".$rows['id']."&name=".$rows['name']."' target='_blank'>View/Edit</a></td>
                                        <td><a href='remove.php?remove=".$rows['id']."'>Remove</a></td>
                                     </tr>";
                            }
                        }
                        
                        else{
                            
							
							/*echo "<tr> <td colspan='5' class='bold bold1'>".mysqli_num_rows($elseres)."  result(s) found.</td></tr>
							   <tr><td colspan='5' bgcolor='#E8E8E8'><hr color='#000'></hr></td></tr>";*/
							
                            while($elserows = mysqli_fetch_array($elseres)){
                               $x++;
                               echo "<tr>
                                        <td>".$x."</td>
                                        <td>".$elserows['name']."</td>
                                        <td>".$elserows['id']."</td>
                                        <td><a href='view.php?view=".$elserows['id']."&name=".$elserows['name']."' target='_blank'>View/Edit</a></td>
                                        <td><a href='remove.php?remove=".$elserows['id']."'>Remove</a></td>
                                    </tr>";
                            }
                         }
                         
                       ?>
                </table>
        	</div>
        
        </div>     
        
        
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>