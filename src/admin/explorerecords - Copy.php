<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
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
            $optingquery = "and opting = '1'";
        }
        else if($_GET['opting'] == '0') {
            $optingquery = "and opting = '0'";
        }
		if(isset($_GET['preftechs']))
			$in= "and preferred_techs like '%".implode("%", $_GET['preftechs'])."%'";
		else $in='';
        /*and (((spi_1+spi_2+spi_3+spi_4+spi_5+spi_6)/6) between ".$_GET['avgspifrom']." and ".$_GET['avgspito'].")
                    and (spi_".$_GET['selected-sem']." between ".$_GET['spifrom']." and ".$_GET['spito'].")
					and preferred_techs like '".$in."'
		*/
		$sqlquery = "SELECT * 
					from $candidates 
					where name like '%".$_GET['name']."%' 
					and city like '%$temphometown%'
			 		and preferred_city like '%$tempprefcity%'
					and (hsc between ".$_GET['hscfrom']." and ".$_GET['hscto'].")
		            and (ssc between ".$_GET['sscfrom']." and ".$_GET['sscto'].")
		            and (diploma between ".$_GET['diplomafrom']." and ".$_GET['diplomato'].")
                    and (cpi between ".$_GET['cpifrom']." and ".$_GET['cpito'].")
					and (((spi_1+spi_2+spi_3+spi_4+spi_5+spi_6)/6) between ".$_GET['avgspifrom']." and ".$_GET['avgspito'].")
					and (spi_".$_GET['selected-sem']." between ".$_GET['spifrom']." and ".$_GET['spito'].")
					".$in."
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
<title>Explore Records | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/explorerecords.css" />


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
		<div id="heading">
			Explore Records
		</div>
        <div align="center">
        <form method="get" action="#">
        	<div id="selectors">
            <div id="first">
            <table>
            <tr><td>
            <label for="nm">Search by Name :</label></td><td> <input type="text" id="nm" name="name" value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>" autofocus /></td></tr>
			<tr><td>
            <label for="ht">Hometown :</label></td><td><select name="hometown" id="ht">
                <?php echo "<option value='all' selected>All</option>";
				
	                       while($rows = mysqli_fetch_array($hometowns)){
							   
							   if($rows['hometown']=='') break;
							   else if(isset($_GET['hometown']) && $rows['hometown']==$_GET['hometown']) echo "<option value='".$rows['hometown']."' selected>". $rows['hometown'] ."</option>";
			                   else echo "<option value='".$rows['hometown']."'>". $rows['hometown'] ."</option>";
                           }
	                       echo "</select>";
                ?>
                </td></tr>
                <tr><td>
            <label for="pc">Preferred City :</label></td><td><select name="pref_city" id="pc">
            	<?php echo "<option value='all' selected>All</option>";

	                       while($rows = mysqli_fetch_array($prefcities)){
							   
							   if($rows['prefcity']=='') break;
							   else if(isset($_GET['pref_city']) && $rows['prefcity']==$_GET['pref_city']) echo "<option value='".$rows['prefcity']."' selected>". $rows['prefcity'] ."</option>";
			                   else echo "<option value='".$rows['prefcity']."'>". $rows['prefcity'] ."</option>";
                           }
	                       echo "</select>";
                ?>
                </td></tr>
                <tr><td>
             <label for="ssc">SSC :</label></td><td>
				From <input id="from1" name="sscfrom" value="<?php if(isset($_GET['sscfrom'])) echo $_GET['sscfrom']; else echo "0";?>" type="number"> to 
                <input id="to1" name="sscto" type="number" value="<?php if(isset($_GET['sscto'])) echo $_GET['sscto']; else echo "100"; ?>"></td></tr>
                <tr><td>
             <label for="hsc">HSC :</label></td><td>
				From <input id="from1" name="hscfrom" type="number" value="<?php if(isset($_GET['hscfrom'])) echo $_GET['hscfrom']; else echo "0";?>"> to 
                <input id="to1" name="hscto" type="number" value="<?php if(isset($_GET['hscto'])) echo $_GET['hscto']; else echo "100";?>"></td></tr>
                <tr><td>
             <label for="diploma">Diploma :</label></td><td>
				From <input id="from1" name="diplomafrom" type="number" value="<?php if(isset($_GET['diplomafrom'])) echo $_GET['diplomafrom']; else echo "0";?>"> to 
                <input id="to1" name="diplomato" type="number" value="<?php if(isset($_GET['diplomato'])) echo $_GET['diplomato']; else echo "100";?>"></td></tr>
                
                </table>
			</div>
            <div id="sec"><table>
            <tr><td colspan="2">
             		College Results:</td></tr>
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
											/*else if(isset($_GET['cpito']) && $i==$_GET['cpito']) 
												echo "<option value='$i' selected>$i</option>";
											else{*/		
												echo "<option value='$i'>$i</option>";
											
										}
                                ?>
                             </select></td></tr>
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
                             </select></td></tr>
					<tr><td colspan="2">
             		In particular Semester:
                    <select name="selected-sem" id="from1">
                       <?php $i; 
					   for($i=1; $i<=6; $i++){
						    echo "<option value='$i'";
							if(isset($_GET['selected-sem'])&& $_GET['selected-sem']==$i)
								echo " selected";
							echo ">$i</option>";
					   }
					   ?>
                    </select></td></tr>
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
                             </select></td></tr>
                             </table>
			</div>
            <div id="third">
            <table>
            <tr><td colspan="2">
            <label for="pref-techs">Preferred Technologies :</label></td></tr>
            <tr><td>
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="html" 
						<?php if(isset($_GET['preftechs'])){ if(in_array('html',$_GET['preftechs'])) echo "checked";}?> >HTML</input>&nbsp;
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="java"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('java',$_GET['preftechs'],true)) echo "checked";}?> >Java</input>
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="sql"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('sql',$_GET['preftechs'])) echo "checked";}?> >SQL</input>
                        <input type="checkbox" name="preftechs[]" id="pref-techs" value="javascript"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('javascript',$_GET['preftechs'])) echo "checked";}?>  >JavaScript</input></td></tr>
             <tr><td>
             			<input type="checkbox" name="preftechs[]" id="pref-techs" value="c"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('c',$_GET['preftechs'],true)) echo "checked";}?>  >C</input>
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="css"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('css',$_GET['preftechs'])) echo "checked";}?>  >CSS</input>
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="python"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('python',$_GET['preftechs'])) echo "checked";}?>  >Python</input>
                        <input type="checkbox" name="preftechs[]" id="pref-techs" value="php"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('php',$_GET['preftechs'])) echo "checked";}?>  >PHP</input>
						<input type="checkbox" name="preftechs[]" id="pref-techs" value="dotnet"
                        <?php if(isset($_GET['preftechs'])) { if(in_array('dotnet',$_GET['preftechs'])) echo "checked";}?>  >.NET</input></td></tr>                        
			
            <tr><td colspan="2">
            <label for="opt">Opting for placement :</label></td></tr>
            <tr><td>
						<input type="radio" name="opting" id="opt" value="1" <?php if(isset($_GET['opting']) && $_GET['opting']=='1') echo "checked";  ?> >Opting</input>
						<input type="radio" name="opting" id="opt" value="0"  <?php if(isset($_GET['opting']) && $_GET['opting']=='0') echo "checked";  ?> >Non-Opting</input><br>
                        <input type="radio" name="opting" id="opt" value="all"  <?php if((isset($_GET['opting']) && $_GET['opting']=='all') ||
						 !isset($_GET['opting'])) echo "checked";  ?> >Both</input></td></tr>
			
            <tr><td colspan="2">
			<label for="view">Result View :</label></td></tr>
            <tr><td>
						<input type="radio" name="view" id="view" <?php if(isset($_GET['view'])){ if($_GET['view']==0) echo "checked"; } else echo "checked"; ?> value="0" >Minimal</input>
						<input type="radio" name="view" id="view" <?php if(isset($_GET['view']) && $_GET['view']==1) echo "checked"; ?> value="1" >Full</input></td></tr>
			<tr><td>
             			<input type="submit" name="submit" value="Explore" class="input"></td></tr>


                </form>
                
                </table>
                </div>
           </div>
        	
        
        	<div id="results">
                
                <h4 align="center" id="heads">
                    Search Results
                </h4>
                
				<?php 
					if(isset($res1)){ echo "<tr> <td colspan='5' class='bold bold1'>".mysqli_num_rows($res1)."  result(s) found.";
						$_SESSION['rows']=mysqli_num_rows($res1);
						if(isset($res1) && mysqli_num_rows($res1)!=0) {
							echo "<span id=\"excel\">Click <a id='exports'>here</a> to get Excel file of results.</span></td></tr>";
						}
						else echo "</td></tr>";
						echo "<tr><td colspan='13' bgcolor='#E8E8E8'><hr color='#000'></hr></td></tr>";
					}
					else {
						$con = getConnection();
                        $x=0;
                        $else = "SELECT * from $candidates";
                        $elseres = mysqli_query($con, $else);
						
						echo "<tr> <td colspan='5' class='bold bold1'>".mysqli_num_rows($elseres)."  result(s) found.
							<span id=\"excel\">Click <a id='exports'>here</a> to get Excel file of results.</span></td></tr>
							<tr><td colspan='13' bgcolor='#E8E8E8'><hr color='#000'></hr></td></tr>";
						$_SESSION['rows']=mysqli_num_rows($elseres);
					  }
				?>                
                <table border="0" cellpadding="5" cellspacing="5" class="searchtable" id="dvData">
                   

                <?php if(isset($res1)){ 
						$flag=0;
					}
					if((isset($flag) && mysqli_num_rows($res1)!=0) || isset($elseres) ) { ?>
                    <tr bgcolor="#0066FF">
                        <td class="bold" >Index</td>
                        <td class="bold">Name</td>
                        <td class="bold">ID</td>
						<td class="bold">E-Mail</td>
                        <td class="bold">Contact</td>
                        <td class="bold">City</td>
                        <?php if(isset($_GET['view']) && $_GET['view']==1){
						?>
						<td class="bold">SPI 1st</td>
						<td class="bold">SPI 2nd</td>
						<td class="bold">SPI 3rd</td>
						<td class="bold">SPI 4th</td>
						<td class="bold">SPI 5th</td>
						<td class="bold">SPI 6th</td>
						<td class="bold">CPI</td>
                        <td class="bold">SSC</td>
                        <td class="bold">HSC</td>
                        <td class="bold">Diploma</td>
                        <?php }
							else {
							echo "<td class=\"bold\">CPI</td>";
							}
						?>
                        <td class="bold">View/Edit</td>
                        <td class="bold">View CV</td>
                        <td class="bold">Remove</td>
                        
                        <?php }?>
                    </tr>
                    <tr>
                     <td colspan='5' bgcolor="#E8E8E8"></td></tr>
                    <?php
                        if(isset($res1)){
                            $x=0;

                            while($rows = mysqli_fetch_array($res1)){
								$src = '../cv/'.md5($rows['id'],false) . '.doc';
                               $x++;
							   mysqli_num_rows($res1);
                               echo "<tr>
                                        <td >".$x."</td>                                        
                                        <td >".$rows['name']."</td>
                                        <td >".$rows['id']."</td>
										<td>".$rows['email']."</td>
										<td>".$rows['contact']."</td>
										<td>".$rows['city']."</td>";
								if(isset($_GET['view']) && $_GET['view']==1){
									echo"<td >".$rows['spi_1']."</td>
										<td >".$rows['spi_2']."</td>
										<td >".$rows['spi_3']."</td>
										<td >".$rows['spi_4']."</td>
										<td >".$rows['spi_5']."</td>
										<td >".$rows['spi_6']."</td>
										<td >".$rows['cpi']."</td>
										<td >".$rows['ssc']."</td>
										<td >".$rows['hsc']."</td>
										<td >".$rows['diploma']."</td>";
								}
								else {
									echo "<td >".$rows['cpi']."</td>";
								}
									
									
                                    echo"  <td ><a href='view.php?view=".$rows['id']."&name=".$rows['name']."' target='_blank'>View/Edit</a></td>";
									
						  			if (file_exists($src))	echo "<td><a href='".$src."'>View</a></td>";
								   	else echo "<td>No CV</td>";
						   
                                      echo "<td ><a href='remove.php?remove=".$rows['id']."'>Remove</a></td>
                                     </tr>";
                            }
                        }
                        else{
							
                            while($elserows = mysqli_fetch_array($elseres)){
								$src = '../cv/'.md5($elserows['id'],false) . '.doc';
                               $x++;
                               echo "<tr>
                                        <td>".$x."</td>
                                        <td>".$elserows['name']."</td>
                                        <td>".$elserows['id']."</td>
										<td>".$elserows['email']."</td>
										<td>".$elserows['contact']."</td>
										<td>".$elserows['city']."</td>";
								if(isset($_GET['view']) && $_GET['view']==1){
									echo"<td >".$elserows['spi_1']."</td>
										<td >".$elserows['spi_2']."</td>
										<td >".$elserows['spi_3']."</td>
										<td >".$elserows['spi_4']."</td>
										<td >".$elserows['spi_5']."</td>
										<td >".$elserows['spi_6']."</td>
										<td >".$elserows['cpi']."</td>
										<td >".$elserows['ssc']."</td>
										<td >".$elserows['hsc']."</td>
										<td >".$elserows['diploma']."</td>";
								}
								else {
									echo "<td >".$elserows['cpi']."</td>";
								}
								echo "
                                        <td><a href='view.php?view=".$elserows['id']."&name=".$elserows['name']."' target='_blank'>View/Edit</a></td>";
										if (file_exists($src))	echo "<td><a href='".$src."'>View</a></td>";
									   	else echo "<td>No CV</td>";
                                        echo "<td><a href='remove.php?remove=".$elserows['id']."'>Remove</a></td>
                                    </tr>";
                            }
                         }
                       ?>
                </table>
                <?php if(isset($_SESSION['rows']) && $_SESSION['rows']>25) {?>
                <button id="top" onClick="window.location=#"><img src="../images/up-arrow.png" title="Back to Top"></button>
                <?php }?>
        	</div>
        </div>     
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
    <script src="../js/jquery-2.0.1.min.js"></script>
    <script>
	
/*	function before_remove(){
		if(confirm('Are you sure you want to remove this record ?\nThis is irreverisible action.'))
			window.location='<?php echo "remove.php?remove=".$rows['id'].""; ?>';
	}*/
	
	$.fn.extend({ 
         disableSelection: function() { 
              this.each(function() { 
                  if (typeof this.onselectstart != 'undefined') {
                       this.onselectstart = function() { return false; };
                  } else if (typeof this.style.MozUserSelect != 'undefined') {
                       this.style.MozUserSelect = 'none';
                  } else {
                      this.onmousedown = function() { return false; };
                  }
              }); 
          } 
    });
	
	$(document).ready(function() {
		$('html').disableSelection();
		$("#exports").click(function(e) {
			//getting values of current time for generating the file name
			var dt = new Date();
			var day = dt.getDate();
			var month = dt.getMonth() + 1;
			var year = dt.getFullYear();
			var hour = dt.getHours();
			var mins = dt.getMinutes();
			var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
			//creating a temporary HTML link element (they support setting file names)
			var a = document.createElement('a');
			//getting data from our div that contains the HTML table
			var data_type = 'data:application/vnd.ms-excel';
			var table_div = document.getElementById('dvData');
			var table_html = table_div.outerHTML.replace(/ /g, '%20');
			a.href = data_type + ', ' + table_html;
			//setting the file name
			a.download = 'exported_table_' + postfix + '.xls';
			//triggering the function
			a.click();
			//just in case, prevent default behaviour
			e.preventDefault();
		});
	});
</script>
</body>
</html>

