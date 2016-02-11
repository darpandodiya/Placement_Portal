<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
	     
    //-----Database connection for cities-----
	$con = getConnection();
    $sqlquery = "SELECT * from cities";
	$cityresult1 = mysqli_query($con, $sqlquery);
    $cityresult2 = mysqli_query($con, $sqlquery);
    if(isset($_REQUEST['view'])) {
        $id = $_REQUEST['view'];
        $name = $_REQUEST['name'];
    }
    else {
        header("Location:home.php");
        exit();
    }
        
	$flag=false;
    if(isset($_POST['submit'])){
		if(isset($_POST['tech1'])){
			$i=0;
			foreach($_POST['tech1'] as $t){
				if($i==0){
					$prefs=$t;
				}
				else{
					$prefs = $prefs .','. $t;
				}
				$i++;
			}
		}
		else $prefs='';

		if(isset($_POST['skill'])){
			$i=0;
			foreach($_POST['skill'] as $t){
				if($i==0){
					$skills=$t;
				}
				else{
					$skills = $skills .','. $t;
				}
				$i++;
			}
		}
		else $skills='';
		
		$kflag=0;
		if(isset($_POST['skill1'])){
			$o_skills = $_POST['skill1'];
			$kflag=2;
		}
		if(isset($_POST['skill2'])){
			if($kflag!=0)
				$o_skills = $o_skills .','.$_POST['skill2'];
			else $o_skills = $_POST['skill2'];
			$kflag=4;
		}
		if(isset($_POST['skill3'])){
			if($kflag!=0)
				$o_skills = $o_skills .','.$_POST['skill3'];
			else $o_skills = $_POST['skill3'];
			$kflag=6;
		}
		if($kflag==0) $o_skills='';
        
//		$myDateTime = DateTime::createFromFormat('Y-m-d', $_POST['DOB']);
		$city = (isset($_POST['citydrop']) && $_POST['citydrop'] != '') ? $_POST['citydrop'] : $_POST['city'];
		mysqli_query($con,"UPDATE $candidates SET 
							id = '".$_POST['stu_id']."',
							rollno = '".$_POST['roll']."',
							name = '".$_POST['name']."',
                            contact = '".$_POST['cont']."',
                            contact_landline = '".$_POST['cont_land']."', 
                            email = '".$_POST['mail']."', 
                            city = '".$city."', 
                            preferred_city = '".$_POST['city_next']."', 
                            address = '".$_POST['address']."', 
                            hsc = '".$_POST['hsc']."', 
                            ssc = '".$_POST['ssc']."', 
                            diploma = '".$_POST['diploma']."', 
							spi_1 = '".$_POST['spii_1']."',
							spi_2 = '".$_POST['spii_2']."',
							spi_3 = '".$_POST['spii_3']."',
							spi_4 = '".$_POST['spii_4']."',
							spi_5 = '".$_POST['spii_5']."',
							spi_6 = '".$_POST['spii_6']."',
							cpi = '".$_POST['cpi']."',
                            preferred_techs = '".$prefs."', 
                            skills = '".$skills."',
                            other_skills = '".$o_skills."', 
                            birthdate = '".$_POST['DOB-day']."-".$_POST['DOB-mon']."-".$_POST['DOB-year']."' 
                            WHERE id = '".$id."'");		
	}
?>
<!doctype html>
<html>
 	
    <head>
    	<meta charset="utf-8">
    	<title>Profile Management | Placement Cell</title>
  
		<link href="../css/master.css" rel="stylesheet" type="text/css">
        <link href="../css/reg.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../images/fevicon.png" />
    </head>
  
    <body>
  
    	<header id="header">
			<img src="../images/placementlogoSmall.png">
		</header>
	
		<p id="heading">
			Profile of <?php echo $id." | ".$name; ?>
		</p>
     
     <?php
	 	if(isset($_POST['submit'])){
			
				
				if (!isset($_SESSION['already']) && $_FILES['pic']['error'] > 0){
					switch ($_FILES['pic']['error'])
                	{   
                	    case 1:
               	         echo "<div align='center'><font color='#FF0000'> The image is bigger than this form allows. Please select valid image.<br></font></div>";	
           	             break;
          	 	    	case 2:
           	             echo "<div align='center'><font color='#FF0000'> The image is bigger than this form allows. Please select valid image.<br></font></div>";
                         break;
               		    case 3:
                         echo "<div align='center'><font color='#FF0000'> Only part of the file was uploaded. Please select valid file.<br></font></div>";
                         break;
                   		case 4:
                    	 echo "<div align='center'><font color='#FF0000'> No file was uploaded. Please select valid file.<br></font></div>";
                         break;
                	}
				}
				else{
						if ((($_FILES['pic']['type'] == 'image/jpeg') || $_FILES['pic']['type'] == 'image/jpg') && ($tmp='jpg') && $_FILES['pic']['size'] < 1000000 &&
						 $_FILES['pic']['size'] > 0)
						{
							if(file_exists('../photos/'.md5($_SESSION['un'],false) .'.jpg')) 
									unlink('../photos/'.md5($_SESSION['un'],false) .'.jpg');
							$_FILES['pic']['name']=md5($_SESSION['un'],false) .'.jpg';
							$src = '../photos/'.$_FILES['pic']['name'];
							
						
							if(move_uploaded_file($_FILES['pic']['tmp_name'], $src)) {
								//echo '<p>The file has been successfully uploaded.</p>';
								$flag=true;
							}
						}
						else
						{
							echo "<div align='center'><font color='#FF0000'>Invalid image. Please select valid image.</font></div><br>";
							$flag=false;
						}
            	}
        }
		?>
       
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
        
	<?php
		if($flag==true){
			$flag=false;
			echo "<div align='center'><font color='#006600'>Details have been successfully updated.</font></div><br>";	
		}
		$con=mysqli_connect("localhost","root","","projectdb");
		$result = mysqli_query($con,"SELECT * FROM $candidates where id='".$id."'");
		$temp=mysqli_fetch_array($result);
		if(mysqli_num_rows($result) == 1)
		{
	?>
    		<div align='center'>
				<form method='post' action='#' enctype='multipart/form-data'>
			
				<table id='formtable' cellspacing='3px' cellpadding='5px'>
				<tr>
					<td class='description'><label for='name'>Name :</label></td>
					<td >
						<input type='text' name='name' value="<?php echo $temp['name']; ?>" required id='name'/>
					</td>
				</tr>
	  
				<tr>
					<td class='description'><label for='roll'>Roll No :</label></td>
					<td>
						<input type='text' name='roll' value='<?php echo $temp['rollno']; ?>' required id='roll'/>
					</td>
				</tr>
	  
				<tr>
					<td class='description'><label for='stu_id'> College ID :</label></td>
				<td>
						<input type='text' name='stu_id' value='<?php echo $temp['id']; $_SESSION['un']=$temp['id']; ?>' required id='stu_id'/>
				</td>
				</tr>
				
				<tr>
					<td class='description'><label for='mail'>Email<b><font color='#FF0000'>*</font> :</label></td></b>
					<td>
						<input type='email' name='mail' value='<?php echo $temp['email']; ?>' required placeholder='Enter Email here' id='mail'/>
					</td>
				</tr>
				
				<tr>
					<td class='description'><label for='cont'>Contact No.<b><font color='#FF0000'>*</font></b> :
                    <span class="note2"> &nbsp;(+91)</span></label></td>
					<td>
						<input type='text' name='cont' value='<?php echo $temp['contact']; ?>' placeholder='Enter Phone here' required 
                        pattern='[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]' id='cont'/>
					</td>
				</tr>
                
                <tr>
					<td class='description'><label for='cont_land'>Landline No. :</label></td>
					<td>
						<input type='text' name='cont_land' value='<?php if (strlen($temp['contact_landline']) == 9) echo "0"; echo $temp['contact_landline']; ?>' placeholder='(e.g.)  0791234567' pattern='[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]?'  id='cont_land'/>
					</td>
				</tr>
	  
				<tr>
					<td class='description'><label for='DOB'>Birth Date<b><font color='#FF0000'>*</font></b> :</label></td>
					<td>
						<select name="DOB-day" id="DOB" title="Day" required>
                        <option value="" selected disabled>Day</option>
                        <?php $day=1;
						$dates=explode('-',$temp['birthdate']);
							for(;$day <= 31;$day++){
								if(isset($dates[0]) && $dates[0]==$day) echo "<option selected value='".$day."'>".$day."</option>";
								else echo "<option value='".$day."'>".$day."</option>";
							}
						?>
                        </select>
                        
                        <select name="DOB-mon" id="DOB" required title="Month">
                        <option value="" selected disabled>Month</option>
                        <?php 
							$day=1;
							for(;$day <= 12;$day++){
								if(isset($dates[1]) && $dates[1]==$day) echo "<option selected value='".$day."'>".$day."</option>";
								else echo "<option value='".$day."'>".$day."</option>";
							}
						?>
                        </select>
                        
                        <select name="DOB-year" id="DOB" required title="Year">
                        <option value="" selected disabled>Year</option>
                        <?php $day=1985;
							for(;$day <= 2010;$day++){
								if(isset($dates[2]) && $dates[2]==$day) echo "<option selected value='".$day."'>".$day."</option>";
								else echo "<option value='".$day."'>".$day."</option>";
							}
						?>
                        </select>
					
						<!--<input type='date' name='DOB' id='DOB' required value="<?php echo date('d-M-Y', strtotime($temp['birthdate'])); ?>"/>-->
					</td>
				</tr>
				
				<tr>
					<td class='note'>For the following 3 fields, <br>if given grades, enter equivalent marks.<br>
                                     If a field is not applicable, leave it blank.           
                    </td>
					</td>
				</tr>
				<tr>
					<td class='description'><label for='ssc'>10th Standard Marks<b><font color='#FF0000'>*</font></b> :</label></td>
					<td >
						<input type='text' value='<?php echo $temp['ssc']; ?>' autocomplete="off" pattern='([0-9][0-9]|[0-9][0-9].[0-9][0-9]*|100)?' placeholder='(e.g.)  88.88' name='ssc' id='ssc' />
					</td>
				</tr>
				
				<tr>
					<td class='description'><label for='hsc'>12th Standard Marks:</label></td>
					<td >
						<input type='text' pattern='([0-9][0-9]|[0-9][0-9].[0-9][0-9]*|100)?' autocomplete="off" value='<?php echo $temp['hsc']; ?>' placeholder='(e.g.)  88.88' name='hsc' id='hsc' />
					</td>
				</tr>
				
				<tr>
					<td class='description'><label for='diploma'>Diploma Result:</label></td>
					<td >
						<input type='text' pattern='([0-9][0-9]|[0-9][0-9].[0-9][0-9]*|100)?' autocomplete="off" value='<?php echo $temp['diploma']; ?>' placeholder='(e.g.)  88.88' name='diploma' id='diploma' />
					</td>
				</tr>
	  			
                <tr>
                <td></td>
                <td></td>
                </tr>
                
      			<tr><td colspan="2">
                <table id="spi" cellspacing="5px" cellpadding="10px" border="1px">
                <tr>
                <th>Semester</th>
                <td>1st</td>
                <td>2nd</td>
                <td>3rd</td>
                <td>4th</td>
                <td>5th</td>
                <td>6th</td></tr>
                <?php
				echo "<tr>
						<th>SPI</th>
						<td><input type='text' id='tabl-in' name='spii_1' value='".$temp['spi_1']."' /></td>
						<td><input type='text' id='tabl-in' name='spii_2' value='".$temp['spi_2']."' /></td>
						<td><input type='text' id='tabl-in' name='spii_3' value='".$temp['spi_3']."' /></td>
						<td><input type='text' id='tabl-in' name='spii_4' value='".$temp['spi_4']."' /></td>
						<td><input type='text' id='tabl-in' name='spii_5' value='".$temp['spi_5']."' /></td>
						<td><input type='text' id='tabl-in' name='spii_6' value='".$temp['spi_6']."' /></td>
					</tr>";
				?>
                </table>
                </td>
      			</tr>
                
                <tr>
                <td></td>
                <td></td>
                </tr>
                
                <tr>
					<td class='description'><label for='avg_spi'>Average SPI:</label></td>
					<td >
                    	<?php 
							$tot = 0;
							$avg = 0;
							if($temp['spi_1']){ $avg+=$temp['spi_1']; $tot++; }
							if($temp['spi_2']){ $avg+=$temp['spi_2']; $tot++; }
							if($temp['spi_3']){ $avg+=$temp['spi_3']; $tot++; }
							if($temp['spi_4']){ $avg+=$temp['spi_4']; $tot++; }
							if($temp['spi_5']){ $avg+=$temp['spi_5']; $tot++; }
							if($temp['spi_6']){ $avg+=$temp['spi_6']; $tot++; }
							$avg/=$tot;
						?>
						<input type='text' readonly title="Readonly, because not in database. Change in SPI will be reflected here" value='<?php echo $avg; ?>' name='avg_spi' id='avg_spi' />
					</td>
				</tr>
                
                <tr>
					<td class='description'><label for='cpi'>CPI:</label></td>
					<td>
                    <input type='text' value='<?php echo $temp['cpi']; ?>' name='cpi' id='cpi' />
					</td>
				</tr>
                
                <tr>
                <td colspan="2">
                </td>
                </tr>
                
				<tr>
					<td class='description'><label for='pic'>Your Image<b><font color='#FF0000'>*</font></b> :</label>
                    <span class="note">(Max Size: 1 MB)</span></td>
                    <td>
                    
						<?php
                        $src1 = '../photos/'.md5($id,false).'.jpg';
                        echo "<div align='left'>";
                        echo "<table>";
						
                        if (file_exists($src1)){
							$_SESSION['already']=true;
                            echo "<td> 
								  <a href='".$src1."' target='_blank'>
									  <input type='button' value='View' id='view' name='view'>
								  </a>&nbsp;&nbsp;Change:";
						}
                		?>
                    
						<input type='file' accept='image/jpeg' name='pic' id='pic'>
					</td>
				</tr>
	  			</tr></table></div>
      			<tr>
                <td colspan="2">
                </td>
          
                </tr>
      
				<tr>
					<td class='description'><label for='city'>Home Town<b><font color='#FF0000'>*</font></b> :</label></td>
					
                    <td>
					<?php        
                           echo "<span class='drop'><select name='citydrop' class='drop'>
						   	<option value='' disabled selected>-- Please select a city --</option>";
							$found = false;
	                       while($rows = mysqli_fetch_array($cityresult1)){
							   if($temp['city']==$rows[0]){
								    echo "<option value='".$temp['city']."' selected> ".$temp['city']." </option>";
									$found = true;
									continue;
							   }
			                   echo "<option value='".$rows[0]."'>". $rows[0] ."</option>";
                           }
	                       echo "</select></span>";
                        
					?>
					</td>
                    
				</tr>
                <tr>
                    <td>
                    </td>
                    <td class='note'>
                        Please specify below if you didn't find above
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type='text' name='city' id='city' value='<?php if (!$found) echo $temp['city']; ?>' pattern='[^0-9]*'>
                    </td>
                </tr>
	            
                <tr>
                <td></td>
                <td></td>
                </tr>
                <tr>
                <td></td>
                <td></td>
                </tr>
				
                <tr>
					<td class='description'><label for='city_next'>Preferred City to Work<b><font color='#FF0000'>*</font></b> :</label></td>
					<td>
					<?php        
                           echo "<span class='drop'><select name='city_next' class='drop' required>
						   	<option value='' disabled selected>-- Please select a city --</option>";
	                       while($rows = mysqli_fetch_array($cityresult2)){
							   if($rows[1]=='') break;
							   if($temp['preferred_city']==$rows[1]){
								    echo "<option value='".$temp['preferred_city']."' selected> ".$temp['preferred_city']." </option>";
									continue;
							   }
							   
			                   echo "<option value='".$rows[1]."'>".$rows[1]."</option>";
                           }
	                       echo "</select><span class='drop'>";
                        
					?>
				</td>
				</tr>
                <tr>
                <td></td>
                <td></td>
                </tr>
				<tr>
					<td class='description'><label for='address'>Address<b><font color='#FF0000'>*</font></b> :</label></td>
					<td>
						<textarea name='address' rows='3' cols='30' type='text' required placeholder='Enter Address here' id='address'><?php echo $temp['address']; ?></textarea>
					</td>
				</tr>
	  			<tr>
                <td></td>
                <td></td>
                </tr>
				<tr>
					<td class='description'>Preferred Technologies<b>:</td>
					<td>
						<table cellpadding='4px'>
                        <?php
							$pref_techs=explode(',',$temp['preferred_techs']);
							$soft_skills=explode(',',$temp['skills']);
						?>
								<tr>
									<td>	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('html',$pref_techs)) echo 'checked'; ?>
                                    	value='html'>HTML</input> </td>
                                     
									<td>	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('java',$pref_techs)) echo 'checked'; ?>
                                    	value='java'>Java</input> </td>
                                     
									<td>	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('sql',$pref_techs)) echo 'checked'; ?>
                                    	value='sql'>SQL</input> </td>
								</tr>
	  
								<tr>
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('javascript',$pref_techs)) echo 'checked'; ?>
                                    	value='javascript'>JavaScript</input> </td>
                                    
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('c',$pref_techs)) echo 'checked'; ?>
                                    	value='c'>C</input> </td>
                                        
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('css',$pref_techs)) echo 'checked'; ?>
                                    	value='css'>CSS</input></td>
								</tr>
								
								<tr>
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('python',$pref_techs)) echo 'checked'; ?>
                                    	value='python'>Python</input> </td>
                                        
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('php',$pref_techs)) echo 'checked'; ?>
                                    	value='php'>PHP</input> </td>
                                        
									<td>  	<input type='checkbox' name='tech1[]' id='tech1' <?php if(in_array('dotnet',$pref_techs)) echo 'checked'; ?>
                                    	value='dotnet'>.NET</input></td>
								</tr>
						</table>
					</td>
				</tr>
				<tr>
                <td></td>
                <td></td>
                </tr>
				<tr>
					<td class='description'><label for='skill[]'>More Software skills :</label></td>
					<td>
						<table cellpadding='4px'>
                        
								<tr>
									<td>	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('photoshop',$soft_skills)) echo 'checked'; ?>
                                    	value='photoshop'>Photoshop</input> </td>
                                        
									<td>	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('excel',$soft_skills)) echo 'checked'; ?>
                                    	value='excel'>Excel</input> </td>
                                        
									<td>	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('autocad',$soft_skills)) echo 'checked'; ?>
                                    	value='autocad'>AutoCAD</input> </td>
								</tr>
	  
								<tr>
									<td>  	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('coreldraw',$soft_skills)) echo 'checked'; ?>
                                    	value='coreldraw'>CorelDraw</input> </td>
                                        
									<td>  	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('matlab',$soft_skills)) echo 'checked'; ?>
                                    	value='matlab'>MATLAB</input></td>
                                        
									<td>  	<input type='checkbox' name='skill[]' id='tech1' <?php if(in_array('flash',$soft_skills)) echo 'checked'; ?>
                                    	value='flash'>Flash</input></td>
								</tr>
								
								
						</table>
					</td>
				</tr>
				<tr>
                    <td>
                    </td>
                    
                    <td>
                        <table cellspacing='2px'>
                            <tr>
                                <td>
                                    Others:&nbsp;&nbsp;&nbsp;<span class="note">(Please be specific)</span>
                                </td>
                            </tr>
                            <?php
								$other_skills=explode(',',$temp['other_skills']);
								if(!isset($other_skills[0]))
									$other_skills[0] = '';
								if(!isset($other_skills[1]))
									$other_skills[1] = '';
								if(!isset($other_skills[2]))
									$other_skills[2] = '';
							?>
                            <tr>
                                <td>
                                    <input type='text' name='skill1' id='skill' size='30px' value='<?php echo $other_skills[0]?>'>
                                </td>
                            </tr>
                    
                            <tr>
                                <td>
                                    <input type='text' name='skill2' id='skill' size='30px' value='<?php echo $other_skills[1]?>'>
                                </td>
                            </tr>
                    
                            <tr>
                                <td>
                                    <input type='text' name='skill3' id='skill' size='30px' value='<?php echo $other_skills[2]?>'>
                                </td>
                            </tr>
                        </table>
                    </td>
				</tr>
	  
				<tr>
					<td>
						<input type='submit' name='submit' value='Update' id='submit'/>
					
						<input type='reset' value='Reset' name='reset' id='reset'/>
					</td>
				</tr>
				<tr><td>
						<div align='left'> <b><font color='#FF0000' size=0.8em>*</font></b> Required fields</div>
				</td></tr>
			</table>
	  
		</form>

		</div>
	<?php } ?>
 	
  <p align="center">
  		<footer id="footer">
			&copy; 2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
		</footer>	
   </p>
	</body>
</html>