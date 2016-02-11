<?php
	require('../functions/isadminloggedin.php');
    require('../functions/gettable.php');
    $con = getConnection();
     
    $isFileUploaded = 0;  
    $isCSVUploaded = 0; 
?>        

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Database Management | Placement Cell</title>

<link type="text/css" rel="stylesheet" href="../css/master.css" />
<link type="text/css" rel="stylesheet" href="../css/managedatabase.css" />

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
		<p id="heading">
			Database Management
		</p>
        
        <div class="addtodb">
            
            <p class="instruction" align="center">
                Add Excel(.xls) file of student data. Click <a href="../static/SampleImport.xls" target="_blank"> here </a> to view the sample. <br><br>
            </p>       
            
            <form action='' method='post' id='upform' enctype='multipart/form-data'>
                <table align="center" style="margin-top:-20px;">
                    <tr>
                        <td>
                            <div class="input">
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                <input type="file" accept="application/vnd.ms-excel" name="file" class="input">
                            </div>
                        </td>
                        
                        <td>    
                            <select name="branch" class="input">
                                  <option selected value="ce">CE&nbsp;</option>
                                  <!--<option value="mh">MH</option>
                                  <option value="it">IT</option>
                                  <option value="ec">EC</option>
                                  <option value="ic">IC</option>
                                  <option value="ch">CH</option>
                                  <option value="cl">CL</option>-->
                                  
                            </select>
                       </td>
                       
                       <td>     
                            <select name="year" class="input">
                                <?php
                                    $startYear=2010;
                                    
                                    for($i=$startYear; $i<=2025; $i++) {
                                        echo "<option value='$i'> $i </option>"; 
                                    }
                                ?>  
                            </select>
                       </td>    
                       
                       <td>     
                            <div id="uploaddbbutton">
                                <input name="upload" type="submit" value="Add" class="input1">
                             
                            </div>
                       </td>
                    </tr>
                </table>           
            </form>
            <?php               
                if(isset($_POST['upload'])) {   
                    $branch = $_POST['branch']; 
                    $batchYear = $_POST['year'];
                
                    
                    $src = "$branch$batchYear.xls";
                
                    if ($_FILES['file']['error'] > 0) {
                        switch ($_FILES['file']['error']) {   
                            case 1:
                                echo '<p> The file is bigger than this form allows. Please select valid file.</p>';
                                break;
                            case 2:
                                echo '<p> The file is bigger than this form allows. Please select valid file.</p>';
                                break;
                            case 3:
                                echo '<p> Only part of the file was uploaded. Please select valid file.</p>';
                                break;
                            case 4:
                                echo '<p> No file was uploaded. Please select valid file.</p>';
                                break;
                        }
                        
                     }
                     
                     else {        
                        $allowedExts = array('xls');
                        $temp = explode('.', $_FILES['file']['name']);
                        $extension = end($temp);
                
                        if (($_FILES['file']['type'] == 'application/vnd.ms-excel') && ($_FILES['file']['size'] < 2000000 && $_FILES['file']['size'] > 0) && in_array($extension, $allowedExts)) {
                                if(move_uploaded_file($_FILES['file']['tmp_name'], $src)) {
                                    //echo 'Excel uploaded.';
                                    $isFileUploaded=1;
                                }
                        }
                        else {
                            echo '<p>Invalid file. Please select valid file.</p>';
                        }
                    }
                     
                     //If Excel file uploaded properly then convert it into .csv and create appropriate table
                     if($isFileUploaded == 1) {
                           
                           require('../functions/PHPExcel/Classes/PHPExcel.php');
                           $objReader = PHPExcel_IOFactory::createReader("Excel5"); //Excel is the type of excel file.
                           
                           $objReader->setReadDataOnly(true);   
                           $objPHPExcel = $objReader->load($src);
                           $fileType=PHPExcel_IOFactory::identify($src);
                           $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
                           $objWriter->save("$branch$batchYear.csv");
                           
                           $isCSVUploaded = 1;
                           //echo 'CSV uploaded.';
                           
                     }
                     
                     if($isCSVUploaded == 1) {
                         
                         $sqlquery1 = "CREATE TABLE IF NOT EXISTS $branch$batchYear (
                                        id varchar(10) NOT NULL ,
                                        PRIMARY KEY(id),
                                        name varchar(30) NOT NULL,
                                        birthdate varchar(10) NOT NULL,
                                        hashedpass varchar(64) NOT NULL,
                                        has_logged_once bit(1)  DEFAULT b'0',
                                        rollno varchar(6) NOT NULL,
                                        contact bigint(10) NOT NULL,
                                        contact_landline bigint(10) NULL,
                                        email varchar(255) NOT NULL,
                                        city varchar(40) NOT NULL,
                                        preferred_city varchar(40) NOT NULL,
                                        ssc double NOT NULL,
                                        hsc varchar(7) NOT NULL,
                                        diploma varchar(7) NOT NULL,
                                        spi_1 varchar(7) NOT NULL,
                                        spi_2 varchar(7) NOT NULL,
                                        spi_3 varchar(7) NOT NULL,
                                        spi_4 varchar(7) NOT NULL,
                                        spi_5 varchar(7) NOT NULL,
                                        spi_6 varchar(7) NOT NULL,
                                        cpi varchar(7) NOT NULL,
                                        address varchar(500) NOT NULL,
                                        preferred_techs set('html', 'java', 'sql', 'javascript', 'c', 'css', 'python', 'php', 'dotnet') NULL,
                                        skills set('photoshop', 'excel', 'autocad', 'coreldraw', 'matlab', 'flash') NULL,
                                        other_skills varchar(100) NULL,
                                        opting bit(1)  DEFAULT b'1')";
                                       
                         $sqlquery13 = "CREATE TABLE IF NOT EXISTS xref".$branch.$batchYear." (
                                        sid varchar(10),
                                        eid int(11),
                                        PRIMARY KEY(sid,eid))";
                                        
                         $result13 = mysqli_query($con, $sqlquery13);
                         
                         $sqlquery14 = "CREATE TABLE IF NOT EXISTS event".$branch.$batchYear." (
                                        id int(10) AUTO_INCREMENT,
                                        PRIMARY KEY(id),
                                        date varchar(10),
                                        time varchar(25),
                                        eligibility	varchar(25),
                                        description	varchar(500),
                                        ispublished	tinyint(1),
                                        type varchar(10),
                                        name varchar(50))";
                                        
                         $result14 = mysqli_query($con, $sqlquery14);
                         
                         $result1 = mysqli_query($con, $sqlquery1);
                         //print_r($result1);
                         
                         $sqlquery2 = "ALTER TABLE $branch$batchYear DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
                         $result2 = mysqli_query($con, $sqlquery2);   
                         //print_r($result2);
                         
                         $sqlquery3 = "LOAD DATA LOCAL INFILE '$branch$batchYear.csv' 
                                       INTO TABLE $branch$batchYear
                                       CHARACTER SET utf8 
                                       FIELDS TERMINATED BY ','
                                       ENCLOSED BY '\"' 
                                       LINES TERMINATED BY '\r\n'
                                       IGNORE 1 LINES
                                       (id, rollno, name, spi_1, spi_2, spi_3, spi_4, spi_5, spi_6, cpi)";
                         
                         $result3 = mysqli_query($con, $sqlquery3);   
                         
                         $sqlquery4 = "SELECT * FROM $branch$batchYear";
                         $result4 = mysqli_query($con, $sqlquery4);   
                         require('../functions/randompass.php');
                         
                         while($rows2 = mysqli_fetch_array($result4)){
                            
                            $sqlquery55 = "UPDATE $branch$batchYear SET hashedpass='".generate_password()."' WHERE id='".$rows2['id']."'";
                            $result55 = mysqli_query($con, $sqlquery55);   
                         }
                         
                         $sqlquery12 = "UPDATE current 
                                        SET branch='".$branch.$batchYear."',
                                            event='event".$branch.$batchYear."',
                                            xref='xref".$branch.$batchYear."'";
                         $result12 = mysqli_query($con, $sqlquery12);   
                    
                         //header("Location:managedatabase.php");
                   
                         unlink($src);
                         unlink("$branch$batchYear.csv");
                         
                         echo "<p style='text-align:center'>Batch ". strtoupper($branch)."$batchYear added.</p>"; 	
                     }  
                }
            ?>

        </div>
        
        <div class="addtodb">
        
            <?php
                if(isset($_POST['activate'])) {
                    //$sqlquery9 = "TRUNCATE current";
                    //$result9 = mysqli_query($con, $sqlquery9);
                    $cy = $_POST['currentyear'];
                    $sqlquery10 = "UPDATE current SET branch='$cy', event='event$cy', xref='xref$cy'";
                    $result10 = mysqli_query($con, $sqlquery10);
                    
                    header("Location:managedatabase.php");    
                }
            ?>
            <table align="center">
                <tr>
                    <td colspan="3">
                        Current Batch in Use 
                        <strong>
                            <?php
                                $sqlquery6 = "SELECT * FROM current";
                                $result6 = mysqli_query($con, $sqlquery6);
                                $currentbatchyear = mysqli_fetch_array($result6);
                                
                                echo strtoupper($currentbatchyear[0]);
                            ?>    
                        </strong>
                    </td>
                </tr>
                <?php
						if($currentbatchyear[0] == 'none')
						{
				?>
                <tr>
                	<td colspan="3">
                    	<span id="error">WARNING! The system is in an inconsistent state!<br>You must activate a batch.</span>
                    </td>
                </tr>
				<?php
						}
				?>
                <form action='' method='post'>
                    <tr>
                        <td>
                            Use Another Batch
                        </td>    
                        <td> 
                              
                            <select name="currentyear" class="input">
                                <?php
                                    
                                    echo "<option value='none'>None</option>";
                                    
                                    $sqlquery8 = "SHOW TABLES LIKE 'ce20%'";
                                    $result8 = mysqli_query($con, $sqlquery8);
    
                                    while($temp1 = mysqli_fetch_array($result8)) {
                                          echo "<option value='$temp1[0]'>".strtoupper($temp1[0])."</option>"; 
                                    }
                                    
                                ?>  
                            </select>
                        </td>
                        <td>
                           <input name="activate" type="submit" value="Activate" class="input1">
                        </td>
                    </tr>
                </form>
            </table>                
        </div>
       
        <div id="alreadyindb" class="addtodb">
            <div align="center">
                Previous Batches in Database
            </div>
            
            <table id="alreadyindbtable" align="center" cellspacing="10px" cellpadding="10px;">
            
                <?php
                    
                    $sqlquery5 = "SHOW TABLES LIKE 'ce20%'";
                    $result5 = mysqli_query($con, $sqlquery5);
                    
                    while($table = mysqli_fetch_array($result5)) { 
                        echo "<tr>
                                    <td>
                                        ".strtoupper($table[0])."
                                    </td>
                                    <td>
                                        <form action='' method='post'>
                                            <input type='hidden' name='tablename' value='$table[0]'>
                                            <input name='remove' type='submit' value='Remove' class='input2'>
                                        </form>
                                    </td>
                              </tr>";
                    }
                ?>
                
            </table>
        
        <?php
            if(isset($_POST['remove'])) {
                        $tablename = $_POST['tablename'];
                        
                        $sqlquery17 = "SELECT id FROM $tablename";
                        $result17 = mysqli_query($con, $sqlquery17);
                        
                        while($rows3 = mysqli_fetch_array($result17)) {
                            $deletedocsrc = '../cv/'.md5($rows3['id'],false) . '.doc';
                            if (file_exists($deletedocsrc)) 
                                unlink($deletedocsrc);
                             
                            $deleteimgsrc = '../photos/'.md5($rows3['id'],false) . '.jpg';
                            if (file_exists($deleteimgsrc)) 
                                unlink($deleteimgsrc);      
                                
                        }

                        
                        $sqlquery7 = "DROP TABLE $tablename";
                        $result7 = mysqli_query($con, $sqlquery7);

                        $sqlquery15 = "DROP TABLE xref".$tablename;
                        $result15 = mysqli_query($con, $sqlquery15);

                        $sqlquery16 = "DROP TABLE event".$tablename;
                        $result16 = mysqli_query($con, $sqlquery16);
                        
                        $sqlquery10 = "SELECT * FROM current";
                        $result10 = mysqli_query($con, $sqlquery10);
                        $temp2 = mysqli_fetch_array($result10);
                        
                        if($temp2[0] == $tablename) {
                            $sqlquery11 = "UPDATE current SET branch='none', event='none', xref='none'";
                            $result11 = mysqli_query($con, $sqlquery11);       
                        }
                        
                        
                        header("Location:managedatabase.php");        
            }
        ?>    
	</div>	
        
    <footer id="footer">
		&copy;2014 Computer Engineering Department, Dharmsinh Desai University, Nadiad.
	</footer>
</body>
</html>